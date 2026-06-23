<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            Attiva l’autenticazione a due fattori per aumentare la sicurezza del tuo account.
        </div>

        {{-- STEP 1: ATTIVAZIONE --}}
        @if(!auth()->user()->two_factor_secret)

            <form method="POST" action="{{ route('2fa.enable') }}">
                @csrf

                <x-button>
                    Attiva 2FA
                </x-button>
            </form>

        @endif


        {{-- STEP 2: QR CODE + CONFERMA --}}
        @if(auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)

            <div class="mt-4 text-sm text-gray-600">
                Scarica l'applicazione Google Authenticator e scansiona questo QR code:
            </div>

            <div class="mt-4">
                {!! auth()->user()->twoFactorQrCodeSvg() !!}
            </div>

            <form method="POST" action="{{ route('2fa.confirm') }}" class="mt-4">
                @csrf

                <x-label for="code" value="Codice di verifica" />
                <x-input id="code"
                         type="text"
                         name="code"
                         class="block mt-1 w-full"
                         autofocus />

                @error('code')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                @enderror

                <div class="mt-4">
                    <x-button>
                        Conferma
                    </x-button>
                </div>
            </form>

        @endif


        {{-- STEP 3: COMPLETATO --}}
        @if(auth()->user()->two_factor_confirmed_at)
        
            <div class="mt-4 text-green-600">
                ✔ Autenticazione a due fattori attiva
            </div>
         @if(session('recovery_codes'))
            <h3>Codici di recupero</h3>

            @foreach(session('recovery_codes') as $code)
                <div>{{ $code }}</div>
            @endforeach
        @endif

            <form method="GET" action="/profile">
            <x-button type="submit">
                Torna al profilo
            </x-button>
            </form>

        @endif

    </x-authentication-card>
</x-guest-layout>