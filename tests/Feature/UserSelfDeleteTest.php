<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);
test('un usuario no puede eliminarse a si mismo', function () {
//1) Crear un usuario en la BD de pruebas
   $user=User::factory()->create(
    [

        'email_verified_at'=>now(),
    ]
   );
   //2) Simular que el usuario ha iniciado sesión
    $this->actingAs($user,'web');

    //3) Intentar eliminar al usuario a través de una petición DELETE
  $response= $this->delete(route('admin.users.destroy',$user));

    //4) Esperar que la respuesta sea un error 403 Forbidden
    $response->assertStatus(403);

    //Verificamos que el usuario sigue existiendo en la base de datos
    $this->assertDatabaseHas('users',[
        'id'=>$user->id,
    ]);

});