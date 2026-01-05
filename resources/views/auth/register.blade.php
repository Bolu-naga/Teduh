<x-guest-layout>
    <div class="px-2 py-2">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900">Create an Account</h2>
            <p class="text-sm text-gray-600">Bergabung sebagai Pencari atau Pemilik Kos</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            </form>
    </div>
            <!-- menambahkan field nama dan email -->
    <div>
            <x-input-label for="name" :value="__('Name')" class="font-medium text-gray-700" />
            <x-text-input id="name" 
                              class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5" 
                              type="text" 
                              name="name" 
                              :value="old('name')" 
                              required autofocus autocomplete="name" 
                              placeholder="Paul Yang" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="font-medium text-gray-700" />
            <x-text-input id="email" 
                              class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5" 
                              type="email" 
                              name="email" 
                              :value="old('email')" 
                              required autocomplete="username" 
                              placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
            <!-- menambahkan input password -->
    <div>
            <x-input-label for="password" :value="__('Password')" class="font-medium text-gray-700" />
            <x-text-input id="password" 
                              class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5" 
                              type="password" 
                              name="password" 
                              required autocomplete="new-password" 
                              placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-medium text-gray-700" />
            <x-text-input id="password_confirmation" 
                              class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5" 
                              type="password" 
                              name="password_confirmation" 
                              required autocomplete="new-password" 
                              placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>
            <!-- menambahkan pilihan role  -->
    <div>
            <x-input-label for="role" value="Daftar Sebagai" class="font-medium text-gray-700" />
            <select id="role" name="role"
                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 text-gray-700"
                        required>
                <option value="" disabled selected>Pilih peran anda...</option>
                <option value="customer">Pencari Kos (Customer)</option>
                <option value="pemilik">Pemilik Kos</option>
            </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>
</x-guest-layout>
    