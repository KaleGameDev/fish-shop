<form action="{{ route('users.store') }}" method="POST">
  @csrf
  <input name="name" placeholder="Name" class="form-control mb-2">
  <input name="email" placeholder="Email" class="form-control mb-2">
  <input name="phone" placeholder="Phone" class="form-control mb-2">
  <button class="btn btn-primary">Lưu</button>
</form>