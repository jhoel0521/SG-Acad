<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Rol -->
        <div class="mt-4">
            <x-input-label for="rol" :value="__('Rol')" />
            <select id="rol" name="rol" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">Selecciona un rol</option>
                <option value="estudiante" {{ old('rol') == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                <option value="docente" {{ old('rol') == 'docente' ? 'selected' : '' }}>Docente</option>
            </select>
            <x-input-error :messages="$errors->get('rol')" class="mt-2" />
        </div>

        <!-- Carrera (para estudiante) -->
        <div class="mt-4 estudiante-field" style="display: none;">
            <x-input-label for="carrera" :value="__('Carrera')" />
            <x-text-input id="carrera" class="block mt-1 w-full" type="text" name="carrera" :value="old('carrera')" />
            <x-input-error :messages="$errors->get('carrera')" class="mt-2" />
        </div>

        <!-- Departamento (para docente) -->
        <div class="mt-4 docente-field" style="display: none;">
            <x-input-label for="departamento" :value="__('Departamento')" />
            <x-text-input id="departamento" class="block mt-1 w-full" type="text" name="departamento" :value="old('departamento')" />
            <x-input-error :messages="$errors->get('departamento')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.getElementById('rol').addEventListener('change', function() {
            const rol = this.value;
            document.querySelector('.estudiante-field').style.display = rol === 'estudiante' ? 'block' : 'none';
            document.querySelector('.docente-field').style.display = rol === 'docente' ? 'block' : 'none';
            document.getElementById('carrera').required = rol === 'estudiante';
            document.getElementById('departamento').required = rol === 'docente';
        });
    </script>
</x-guest-layout>
