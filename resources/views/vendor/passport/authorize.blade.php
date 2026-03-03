<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Authorize Access - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 antialiased font-sans min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Card Container -->
        <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-100">
            <!-- Header section -->
            <div class="px-6 py-8 sm:px-10 text-center">
                <div class="flex justify-center mb-6">
                    <div
                        class="h-16 w-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                </div>

                <h2 class="text-2xl font-bold tracking-tight text-gray-900 mb-2">
                    Connect with {{ $client->name }}
                </h2>
                <p class="text-sm text-gray-500">
                    <strong>{{ $client->name }}</strong> is requesting access to your
                    <strong>{{ config('app.name') }}</strong> account.
                </p>
            </div>

            <div class="px-6 sm:px-10 pb-6">
                <!-- User Profile Summary -->
                <div class="flex items-center space-x-4 p-4 border rounded-xl bg-gray-50 mb-6">
                    <div
                        class="bg-gray-200 h-10 w-10 flex-shrink-0 rounded-full flex items-center justify-center font-bold text-gray-600 text-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>

                <hr class="border-gray-200 mb-6">

                <!-- Requested Permissions / Scopes -->
                <h3 class="text-sm font-semibold text-gray-900 mb-4 px-1">
                    This will allow {{ $client->name }} to:
                </h3>

                <ul class="space-y-4 mb-8">
                    @forelse ($scopes as $scope)
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-800">{{ $scope->id }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $scope->description }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-700">Access basic profile information and act on your
                                    behalf.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>

                <p class="text-xs text-gray-500 mb-6 text-center">
                    Make sure you trust <strong>{{ $client->name }}</strong> before authorizing.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 sm:space-x-3">
                    <form method="POST" action="{{ route('passport.authorizations.deny') }}" class="w-full">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="state" value="{{ $request->state }}">
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">

                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors">
                            Cancel
                        </button>
                    </form>

                    <form method="POST" action="{{ route('passport.authorizations.approve') }}" class="w-full">
                        @csrf
                        <input type="hidden" name="state" value="{{ $request->state }}">
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">

                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Authorize
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-center">
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">
                    Secured by {{ config('app.name') }}
                </p>
            </div>
        </div>
    </div>
</body>

</html>
