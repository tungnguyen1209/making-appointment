<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Appointment Listing') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif
                    <a href="{{ route('admin.appointment.create') }}"
                       class="mb-4 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                        Create
                    </a>
                    @if ($itemsCount == 0)
                        <div class="min-w-full align-middle">
                            {{__("Don't have any appointments")}}
                        </div>
                    @else
                        <div class="min-w-full align-middle">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Filter') }}
                            </h2>
                            <div class="mt-4">
                                <form action="{{ route('admin.appointment.index') }}" method="GET">
                                <!-- Name -->
                                <div class="mt-4">
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $query['name'] ?? '' }}" autofocus autocomplete="name" />
                                </div>

                                <!-- Email Address -->
                                <div class="mt-4">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" value="{{ $query['email'] ?? '' }}" autocomplete="username" />
                                </div>

                                <!-- Phone -->
                                <div class="mt-4">
                                    <x-input-label for="phone" :value="__('Phone')" />
                                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" value="{{ $query['phone'] ?? '' }}" autocomplete="username" />
                                </div>

                                <!-- Datetime From -->
                                <div class="mt-4">
                                    <x-input-label for="appointment_datetime_from" :value="__('Datetime From')" />
                                    <x-text-input id="appointment_datetime_from" class="block mt-1 w-full" type="datetime-local" name="appointment_datetime_from" value="{{ $query['appointment_datetime_from'] ?? '' }}" autocomplete="username" />
                                </div>

                                <!-- Datetime To -->
                                <div class="mt-4">
                                    <x-input-label for="appointment_datetime_to" :value="__('Datetime To')" />
                                    <x-text-input id="appointment_datetime_to" class="block mt-1 w-full" type="datetime-local" name="appointment_datetime_to" value="{{ $query['appointment_datetime_to'] ?? '' }}" autocomplete="username" />
                                </div>

                                <!-- Description -->
                                <div class="mt-4">
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-textarea-input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $query['description'] ?? '' }}" autocomplete="username" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="ms-4">
                                        {{ __('Filter') }}
                                    </x-primary-button>
                                </div>
                            </form>
                            </div>
                            <div class="mt-4">
                                <table class="min-w-full border divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th class="bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">{{ __('Name') }}</span>
                                    </th>
                                    <th class="w-56 bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">{{ __('Email') }}</span>
                                    </th>
                                    <th class="w-56 bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">{{ __('Phone') }}</span>
                                    </th>
                                    <th class="w-56 bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">{{ __('Datetime') }}</span>
                                    </th>
                                    <th class="w-56 bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">{{ __('Status') }}</span>
                                    </th>
                                    <th class="w-56 bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">{{ __('Action') }}</span>
                                    </th>
                                </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach($items as $item)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $item->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $item->email }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $item->phone }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $item->appointment_datetime }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $item->status }}
                                        </td>
                                        @if ($item->status !== \App\Models\Appointment::CANCELED)
                                            <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                <a href="{{ route('customer.appointment.view', ['id' => $item->id]) }}"
                                                   class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">{{__('Edit')}}
                                                </a>
                                                <form action="{{ route('customer.appointment.cancel', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display: inline-block;">
                                                    @csrf
                                                    @method('PUT')
                                                    <x-danger-button>{{ __('Cancel') }}</x-danger-button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            <div class="mt-4">
                                {!! $items->withQueryString()->links() !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
