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
</x-guest-layout>