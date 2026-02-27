<form action="{{ route('users.update', $user) }}" method="POST">
  @csrf
  @method('PUT')
  <input name="name" value="{{ $user->name }}" class="form-control mb-2">
  <input name="email" value="{{ $user->email }}" class="form-control mb-2">
  <input name="phone" value="{{ $user->phone }}" class="form-control mb-2">
  <button class="btn btn-primary">Cập nhật</button>
</form>