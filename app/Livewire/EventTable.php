<?php

namespace App\Livewire;

use App\Exceptions\EventException;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class EventTable extends PowerGridComponent
{
    use WithExport;

    public string $sortField = 'date';

    public string $sortDirection = 'desc';

    protected $listeners = [
        '$refresh'
    ];

    public bool $deferLoading = true;

    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Event::query()->with(['categories']);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            //->add('id')
            ->add('name')
            ->add('location_name')
            ->add('location_city')
            ->add('date', fn($event) => Carbon::parse($event->date)->format('d-m-y'))
            ->add('categories', fn($event) => implode(
                ', ',
                $event->categories->pluck('name')->toArray()
            ))
            ->add('registration');
    }

    public function columns(): array
    {
        return [
            //Column::make('ID', 'id'),
            Column::make(__('event.table.name'), 'name')->searchable()->sortable(),
            Column::make(__('event.table.location_name'), 'location_name')->searchable()->sortable(),
            Column::make(__('event.table.location_city'), 'location_city')->searchable()->sortable(),
            Column::make(__('event.table.date'), 'date')->searchable()->sortable(),
            Column::make(__('event.table.categories'), 'categories')->searchable()->sortable(),
            Column::make(__('event.table.registration'), 'registration')->searchable()->sortable()->toggleable(),
            Column::action(__('event.table.actions'))
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }


    protected function rules()
    {
        return [
            'registration' => ['required', 'sometimes', 'nullable', 'boolean'],
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    #[\Livewire\Attributes\On('show')]
    public function show($rowId): void
    {
        $this->redirectRoute('members.index', ['event' => $rowId]);
    }

    public function onUpdatedToggleable(string|int $id, string $field, string $value): void
    {
        try {
            DB::beginTransaction();

            Event::query()->find($id)->update([
                $field => e($value),
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error on update of event', [$e->getMessage()]);
            throw new EventException();

        }

        $this->skipRender();
    }


    public function actions(Event $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: ' . $row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id]),

            Button::add('show')
                ->slot('Show: ' . $row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('show', ['rowId' => $row->id]),
        ];
    }


    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
