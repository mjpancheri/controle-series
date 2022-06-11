<x-layout title="Login">
    <div class="container w-50 mt-1">
        <form method="post">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-info mt-2">Register</a>
            <button type="submit" class="btn btn-primary float-end mt-2">Login</button>
        </form>
    </div>
</x-layout>
