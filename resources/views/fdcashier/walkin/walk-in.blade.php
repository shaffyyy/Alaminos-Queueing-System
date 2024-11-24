<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Walk-in Form
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('fdcashier-walkin-store') }}" method="POST">
                    @csrf

                    <!-- User Selection -->
                    <div class="mb-4">
                        <label for="user_id" class="block text-gray-700 font-bold mb-2">Select User</label>
                        <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                            <option value="">Select a User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->usertype == 4 ? 'PWD' : 'User' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Service Selection -->
                    <div class="mb-4">
                        <label for="service_id" class="block text-gray-700 font-bold mb-2">Select Service</label>
                        <select name="service_id" id="service_id" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                            <option value="">Select a Service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Priority Selection -->
                    {{-- <div class="mb-4">
                        <label for="priority" class="block text-gray-700 font-bold mb-2">Select Priority</label>
                        <select name="priority" id="priority" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                            <option value="0">Regular</option>
                            <option value="1">Priority</option>
                        </select>
                    </div> --}}

                    <!-- Queue Number -->
                    <div id="queue-number-container" class="mb-4 hidden">
                        <label class="block text-gray-700 font-bold mb-2">Queue Number</label>
                        <div id="queue-number" class="w-full max-w-md mx-auto p-4 border border-gray-300 rounded-lg bg-gray-50 text-center relative receipt">
                            <!-- Logo -->
                            <div class="flex justify-center mb-2">
                                <x-application-mark class="block h-12 w-auto" />
                            </div>

                            <!-- Queue Number -->
                            <span id="queue-number-value" class="font-mono text-2xl font-bold text-gray-700"></span>
                        </div>

                        <!-- Print Button -->
                        <div class="flex justify-center mt-4">
                            <button id="print-ticket" type="button" class="bg-green-500 text-white px-4 py-1 rounded-lg hover:bg-green-600 transition duration-200 text-sm">
                                Print Ticket
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('fdcashier-walkin') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</a>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Assign Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2 for dropdowns
            $('#user_id, #service_id, #priority').select2();

            // Dynamically generate the queue number based on service selection
            $('#service_id').on('change', function () {
                const serviceId = $(this).val();

                if (serviceId) {
                    $.ajax({
                        url: "{{ route('fdcashier.get-next-queue-number') }}",
                        method: "POST",
                        data: {
                            service_id: serviceId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.queueNumber) {
                                $('#queue-number-value').text(response.queueNumber);
                                $('#queue-number-container').removeClass('hidden');
                            }
                        },
                        error: function () {
                            alert('Failed to fetch the queue number. Please try again.');
                        }
                    });
                } else {
                    $('#queue-number-container').addClass('hidden');
                }
            });

            // Print ticket functionality
            $('#print-ticket').on('click', function () {
                const printContent = document.getElementById('queue-number').outerHTML;
                const newWindow = window.open('', '_blank');
                newWindow.document.open();
                newWindow.document.write(`
                    <html>
                    <head>
                        <title>Print Ticket</title>
                        <style>
                            body {
                                font-family: 'Courier New', Courier, monospace;
                                text-align: center;
                                margin: 0;
                                padding: 0;
                            }
                            .receipt {
                                width: 300px;
                                height: 150px;
                                margin: auto;
                                display: flex;
                                flex-direction: column;
                                justify-content: center;
                                align-items: center;
                                border: 1px solid #ccc;
                                border-radius: 10px;
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                padding: 10px;
                                background-color: #fff;
                            }
                            .receipt .block {
                                margin-bottom: 10px;
                            }
                            .font-mono {
                                font-size: 20px;
                                font-weight: bold;
                                margin-top: 5px;
                            }
                        </style>
                    </head>
                    <body onload="window.print(); window.close();">
                        ${printContent}
                    </body>
                    </html>
                `);
                newWindow.document.close();
            });
        });
    </script>

    <style>
        /* Receipt styling */
        .receipt {
            background-color: #fff;
            font-family: 'Courier New', Courier, monospace;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
            max-width: 300px;
        }

        /* Center logo styling */
        .receipt .block {
            margin: 0 auto;
            display: block;
        }
    </style>
</x-app-layout>
