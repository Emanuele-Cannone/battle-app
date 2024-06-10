<?php

namespace App\Imports;


use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EventMemberImport implements ToModel, WithBatchInserts, WithHeadingRow, WithValidation
{
    public int $event_id;

    public int $category_id;


    public function __construct(int $event_id, int $category_id)
    {
        $this->event_id = $event_id;
        $this->category_id = $category_id;
    }


    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row): Member|null
    {
        return new Member([
            'name'          => $row['nome'],
            'surname'       => $row['cognome'],
            'telephone'     => $row['telefono'],
            'email'         => $row['email'],
            'school'        => $row['scuola'],
            'teacher'       => $row['insegnante'],
            'event_id'      => $this->event_id,
            'category_id'   => $this->category_id,
        ]);
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 500;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'nome' => 'string|required',
            'cognome' => 'string|required',
            'telefono' => 'regex:/^[0-9]*$/i|required',
            'email' => 'email|required',
            'scuola' => 'string|required',
            'insegnante' => 'string|required',
        ];
    }


    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            '*.telefono' => 'Custom message for :attribute.',
        ];
    }
}
