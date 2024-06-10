@push('scripts')
    <script type='text/javascript'>
        function handle() {
            return {
                onlyNumber(event) {
                    if(isNaN(event.key) && event.key !== 'Backspace') {
                        event.preventDefault();
                    }
                }
            }
        }
    </script>
@endpush

<x-guest-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="max-w-2xl" x-data="handle()">

                <div
                    x-data="{
                            tabSelected: 1,
                            tabId: $id('tabs'),
                            tabButtonClicked(tabButton){
                                this.tabSelected = tabButton.id.replace(this.tabId + '-', '');
                                this.tabRepositionMarker(tabButton);
                            },
                            tabRepositionMarker(tabButton){
                                this.$refs.tabMarker.style.width=tabButton.offsetWidth + 'px';
                                this.$refs.tabMarker.style.height=tabButton.offsetHeight + 'px';
                                this.$refs.tabMarker.style.left=tabButton.offsetLeft + 'px';
                            },
                            tabContentActive(tabContent){
                                return this.tabSelected == tabContent.id.replace(this.tabId + '-content-', '');
                            },
                            tabButtonActive(tabContent){
                                const tabId = tabContent.id.split('-').slice(-1);
                                return this.tabSelected == tabId;
                            }
                        }"

                    x-init="tabRepositionMarker($refs.tabButtons.firstElementChild);" class="relative w-full max-w-sm">


                    @if(count($errors->getMessages()) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            @foreach($errors->getMessages() as $errorMessages)
                                @foreach($errorMessages as $errorMessage)
                                    <p class="mt-2 text-center text-red-600 dark:text-red-500">
                                        <span class="font-medium">Attenzione!!! Errori presenti nella riga nº {{ $errorMessage }}</span>
                                    </p>
                                @endforeach
                            @endforeach
                        </div>
                    @endif


                    <div x-ref="tabButtons"
                         class="relative inline-grid items-center justify-center w-full h-10 grid-cols-2 p-1 text-gray-500 bg-white border border-gray-100 rounded-lg select-none">
                        <button :id="$id(tabId)" @click="tabButtonClicked($el);" type="button"
                                :class="{ 'bg-gray-100 text-gray-700' : tabButtonActive($el) }"
                                class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">@lang('registration.form.single_registration')</button>
                        <button :id="$id(tabId)" @click="tabButtonClicked($el);" type="button"
                                :class="{ 'bg-gray-100 text-gray-700' : tabButtonActive($el) }"
                                class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">@lang('registration.form.group_registration')</button>
                        <div x-ref="tabMarker" class="absolute left-0 z-10 w-1/2 h-full duration-300 ease-out" x-cloak>
                            <div class="w-full h-full bg-gray-100 rounded-md shadow-sm"></div>
                        </div>
                    </div>
                    <div
                        class="relative flex items-center justify-center w-full p-5 mt-2 text-xs text-gray-400 border rounded-md content border-gray-200/70">

                        <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)" class="relative w-full">


                            <form class="w-full" action="{{ route('registration') }}" method="post">
                                @csrf

                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" name="name" id="floating_name" value="{{ old('name') }}"
                                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                           placeholder=" " />
                                    <label for="floating_name"
                                           class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        @lang('registration.form.name')
                                    </label>
                                    @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                        Username already taken!</p>
                                    @enderror
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" name="surname" id="floating_surname" value="{{ old('surname') }}"
                                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                           placeholder=" " />
                                    <label for="floating_surname"
                                           class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        @lang('registration.form.surname')
                                    </label>
                                    @error('surname')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                        Username already taken!</p>
                                    @enderror
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="tel" name="telephone" id="floating_telephone"  value="{{ old('telephone') }}"
                                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                           placeholder=" " @keydown="onlyNumber($event)" />
                                    <label for="floating_telephone"
                                           class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        @lang('registration.form.telephone')
                                    </label>
                                    @error('telephone')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                        Username already taken!</p>
                                    @enderror
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="email" name="email" id="floating_email"  value="{{ old('email') }}"
                                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                           placeholder=" " />
                                    <label for="floating_email"
                                           class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        @lang('registration.form.email')
                                    </label>
                                    @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                        Username already taken!</p>
                                    @enderror
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" name="school" id="floating_school" value="{{ old('school') }}"
                                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                           placeholder=" " />
                                    <label for="floating_school"
                                           class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        @lang('registration.form.school')
                                    </label>
                                    @error('school')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                        Username already taken!</p>
                                    @enderror
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" name="teacher" id="floating_teacher" value="{{ old('teacher') }}"
                                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                           placeholder=" " />
                                    <label for="floating_teacher"
                                           class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        @lang('registration.form.teacher')
                                    </label>
                                    @error('teacher')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                        Username already taken!</p>
                                    @enderror
                                </div>

                                @foreach($event->categories as $k => $category)
                                    <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700 mt-2">
                                        <input id="bordered-radio-{{ $k }}" type="radio" value="{{ $category->id }}" name="category_id" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="bordered-radio-{{ $k }}" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $category->name }}</label>
                                    </div>
                                @endforeach


                                <button type="submit"
                                        class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Submit
                                </button>
                            </form>


                        </div>

                        <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)" class="relative w-full"
                             x-cloak>
                            <form class="w-full" action="{{ route('registration') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="event_id" value="{{ $event->id }}">


                                <a href="{{ route('members.downloadUserTemplate', ['event' => $event->id]) }}">
                                    <button type="button"
                                            class="w-full my-2 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        <i class="fa-regular fa-file-excel"></i>
                                        @lang('registration.form.download_template')
                                    </button>
                                </a>


                                <div class=" my-5 relative z-0 w-full mb-5 group">
                                    <input type="file" name="member_file" id="floating_member_file"
                                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                           placeholder=" " />
                                    @error('member_file')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                        Username already taken!</p>
                                    @enderror
                                </div>


                                <button type="submit"
                                        class="mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Submit
                                </button>

                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</x-guest-layout>
