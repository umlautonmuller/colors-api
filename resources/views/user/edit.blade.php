<form action="/api/user/{{$user->id}}" method="post">
    @method("PUT")
    <input type="text" name="name" placeholder="Name" value="{{$user->name}}">
    <input type="email" name="email" placeholder="Email" value="{{$user->email}}">
    <input type="submit" value="Enviar">
</form>