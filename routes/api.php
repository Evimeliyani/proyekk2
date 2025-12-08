use App\Http\Controllers\Api\AbsensiApiController;

Route::post('/presensi', [AbsensiApiController::class, 'store']);

