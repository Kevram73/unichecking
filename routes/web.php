<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EnseignantUEController;
use App\Http\Controllers\FaculteController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\DeplacementController;
use App\Http\Controllers\CallbackController;

use App\Http\Controllers\PosteController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\TypePieceIdentiteController;
use App\Http\Controllers\TypeDeplacementController;
use App\Http\Controllers\UEController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UniversiteController;
use App\Http\Controllers\AnneeController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\ScanPresenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;


Route::get('/', [AuthController::class, 'login_get'])->name('login');
Route::post('/login', [AuthController::class, 'login_post'])->name('auth.login');
Route::get('/forgot/password', [AuthController::class, 'forget_pwd_get'])->name('forgot_password');
Route::post('/forgot/password', [AuthController::class, 'forget_pwd_post'])->name('fpwd');
Route::get('/reset/password/{token}', [AuthController::class, 'reset_pwd_get'])->name('reset_password');
Route::post('/reset/password', [AuthController::class, 'reset_pwd_post'])->name('reset_pwd');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');



Route::resource('annees', AnneeController::class);
Route::resource('enseignants', EnseignantController::class);
Route::resource('deplacements', DeplacementController::class);
Route::resource('facultes', FaculteController::class);
Route::resource('filieres', FiliereController::class);
Route::resource('grades', GradeController::class);
Route::resource('postes', PosteController::class);
Route::resource('specialites', SpecialiteController::class);
Route::resource('seances', SeanceController::class);
Route::resource('type_deplacements', TypeDeplacementController::class);
Route::resource('type_pieces', TypePieceIdentiteController::class);
Route::resource('ues', UEController::class);
Route::resource('universites', UniversiteController::class);

Route::get('/enseignant/choose', [SeanceController::class, 'choose_enseignant'])->name('seance.choose');
Route::get('/enseignant/choose/{id}', [SeanceController::class, 'choice'])->name('seance.choice');
Route::get('/filieres/get/{id}', [SeanceController::class, 'getFilieres'])->name('seance.filiere');

// Route::prefix('annees')->group(function () {
//     Route::get('/', [AnneeController::class, 'index']);
//     Route::post('/', [AnneeController::class, 'store']);
//     Route::get('/{id}', [AnneeController::class, 'show']);
//     Route::put('/{id}', [AnneeController::class, 'update']);
//     Route::delete('/{id}', [AnneeController::class, 'destroy']);
// });

/**
*** ENSEIGNANT
***/
// Route::post('/enseignant/show', [EnseignantController::class, 'vw_liste'])->name('enseignant.show');
// Route::get('/enseignant/show', [EnseignantController::class, 'vw_liste'])->name('enseignant.show');
// Route::post('/enseignant/edit/{id}', [EnseignantController::class, 'vw_edit'])->name('enseignant.edit');
// Route::get('/enseignant/edit/{id}', [EnseignantController::class, 'vw_edit'])->name('enseignant.edit');
// Route::post('/enseignant/delete/{id}', [EnseignantController::class, 'vw_delete'])->name('enseignant.delete');
// Route::get('/enseignant/delete/{id}', [EnseignantController::class, 'vw_delete'])->name('enseignant.delete');
// Route::post('/enseignant/new', [EnseignantController::class, 'vw_new'])->name('enseignant.new');
// Route::get('/enseignant/new', [EnseignantController::class, 'vw_new'])->name('enseignant.new');
// Route::post('/enseignant/save', [EnseignantController::class, 'vw_save'])->name('enseignant.save');
// Route::get('/enseignant/save', [EnseignantController::class, 'vw_save'])->name('enseignant.save');

/**
*** FACULTE
***/
// Route::post('/faculte/show', [FaculteController::class, 'vw_liste'])->name('faculte.show');
// Route::get('/faculte/show', [FaculteController::class, 'vw_liste'])->name('faculte.show');
// Route::post('/faculte/edit/{id}', [FaculteController::class, 'vw_edit'])->name('faculte.edit');
// Route::get('/faculte/edit/{id}', [FaculteController::class, 'vw_edit'])->name('faculte.edit');
// Route::post('/faculte/delete/{id}', [FaculteController::class, 'vw_delete'])->name('faculte.delete');
// Route::get('/faculte/delete/{id}', [FaculteController::class, 'vw_delete'])->name('faculte.delete');
// Route::post('/faculte/new', [FaculteController::class, 'vw_new'])->name('faculte.new');
// Route::get('/faculte/new', [FaculteController::class, 'vw_new'])->name('faculte.new');
// Route::post('/faculte/save', [FaculteController::class, 'vw_save'])->name('faculte.save');
// Route::get('/faculte/save', [FaculteController::class, 'vw_save'])->name('faculte.save');

/**
*** FILIERE
***/
// Route::post('/filiere/show/{fac_id}', [FiliereController::class, 'vw_liste'])->name('filiere.show');
// Route::get('/filiere/show/{fac_id}', [FiliereController::class, 'vw_liste'])->name('filiere.show');
// Route::post('/filiere/edit/{id}', [FiliereController::class, 'vw_edit'])->name('filiere.edit');
// Route::get('/filiere/edit/{id}', [FiliereController::class, 'vw_edit'])->name('filiere.edit');
// Route::post('/filiere/delete/{id}', [FiliereController::class, 'vw_delete'])->name('filiere.delete');
// Route::get('/filiere/delete/{id}', [FiliereController::class, 'vw_delete'])->name('filiere.delete');
// Route::post('/filiere/new/{fac_id}', [FiliereController::class, 'vw_new'])->name('filiere.new');
// Route::get('/filiere/new/{fac_id}', [FiliereController::class, 'vw_new'])->name('filiere.new');
// Route::post('/filiere/save', [FiliereController::class, 'vw_save'])->name('filiere.save');
// Route::get('/filiere/save', [FiliereController::class, 'vw_save'])->name('filiere.save');

/**
*** SEANCE
***/
// Route::post('/seance/show/', [SeanceController::class, 'vw_liste'])->name('seance.show');
// Route::get('/seance/show/', [SeanceController::class, 'vw_liste'])->name('seance.show');
// Route::post('/seance/edit/{id}', [SeanceController::class, 'vw_edit'])->name('seance.edit');
// Route::get('/seance/edit/{id}', [SeanceController::class, 'vw_edit'])->name('seance.edit');
// Route::post('/seance/delete/{id}', [SeanceController::class, 'vw_delete'])->name('seance.delete');
// Route::get('/seance/delete/{id}', [SeanceController::class, 'vw_delete'])->name('seance.delete');
// Route::post('/seance/new/{ens_ue_id}', [SeanceController::class, 'vw_new'])->name('seance.new');
// Route::get('/seance/new/{ens_ue_id}', [SeanceController::class, 'vw_new'])->name('seance.new');
// Route::post('/seance/save', [SeanceController::class, 'vw_save'])->name('seance.save');
// Route::get('/seance/save', [SeanceController::class, 'vw_save'])->name('seance.save');

/**
*** DEPLACEMENT
***/
// Route::post('/deplacement/show/', [DeplacementController::class, 'vw_liste'])->name('deplacement.show');
// Route::get('/deplacement/show/', [DeplacementController::class, 'vw_liste'])->name('deplacement.show');
// Route::post('/deplacement/edit/{id}', [DeplacementController::class, 'vw_edit'])->name('deplacement.edit');
// Route::get('/deplacement/edit/{id}', [DeplacementController::class, 'vw_edit'])->name('deplacement.edit');
// Route::post('/deplacement/delete/{id}', [DeplacementController::class, 'vw_delete'])->name('deplacement.delete');
// Route::get('/deplacement/delete/{id}', [DeplacementController::class, 'vw_delete'])->name('deplacement.delete');
// Route::post('/deplacement/new/', [DeplacementController::class, 'vw_new'])->name('deplacement.new');
// Route::get('/deplacement/new/', [DeplacementController::class, 'vw_new'])->name('deplacement.new');
// Route::post('/deplacement/save', [DeplacementController::class, 'vw_save'])->name('deplacement.save');
// Route::get('/deplacement/save', [DeplacementController::class, 'vw_save'])->name('deplacement.save');

/**
*** CALLBACK
***/
// Route::post('/log/show', [CallbackController::class, 'show'])->name('log.show');
// Route::get('/log/show', [CallbackController::class, 'show'])->name('log.show');

/**
*** POSTE
***/
// Route::post('/poste/show/', [PosteController::class, 'vw_liste_cat'])->name('poste.show');
// Route::get('/poste/show/', [PosteController::class, 'vw_liste_cat'])->name('poste.show');
// Route::post('/poste/delete/{id}', [PosteController::class, 'vw_delete'])->name('poste.delete');
// Route::get('/poste/delete/{id}', [PosteController::class, 'vw_delete'])->name('poste.delete');
// Route::post('/poste/categorie/delete/{id}', [PosteController::class, 'vw_delete_cat'])->name('poste.delete_cat');
// Route::get('/poste/categorie/delete/{id}', [PosteController::class, 'vw_delete_cat'])->name('poste.delete_cat');
// Route::post('/poste/save', [PosteController::class, 'vw_save'])->name('poste.save');
// Route::get('/poste/save', [PosteController::class, 'vw_save'])->name('poste.save');
// Route::post('/poste/categorie/save', [PosteController::class, 'vw_save_cat'])->name('poste.save_cat');
// Route::get('/poste/categorie/save', [PosteController::class, 'vw_save_cat'])->name('poste.save_cat');

/**
*** GRADE
***/
// Route::post('/grade/show/', [GradeController::class, 'vw_liste'])->name('grade.show');
// Route::get('/grade/show/', [GradeController::class, 'vw_liste'])->name('grade.show');
// Route::post('/grade/delete/{id}', [GradeController::class, 'vw_delete'])->name('grade.delete');
// Route::get('/grade/delete/{id}', [GradeController::class, 'vw_delete'])->name('grade.delete');
// Route::post('/grade/save', [GradeController::class, 'vw_save'])->name('grade.save');
// Route::get('/grade/save', [GradeController::class, 'vw_save'])->name('grade.save');

/**
*** SPECIALITE
***/
// Route::post('/specialite/show/', [SpecialiteController::class, 'vw_liste'])->name('specialite.show');
// Route::get('/specialite/show/', [SpecialiteController::class, 'vw_liste'])->name('specialite.show');
// Route::post('/specialite/delete/{id}', [SpecialiteController::class, 'vw_delete'])->name('specialite.delete');
// Route::get('/specialite/delete/{id}', [SpecialiteController::class, 'vw_delete'])->name('specialite.delete');
// Route::post('/specialite/save', [SpecialiteController::class, 'vw_save'])->name('specialite.save');
// Route::get('/specialite/save', [SpecialiteController::class, 'vw_save'])->name('specialite.save');

/**
*** TYPE_PIECE_IDENTITE
***/
// Route::post('/type_piece/show/', [TypePieceIdentiteController::class, 'vw_liste'])->name('type_piece.show');
// Route::get('/type_piece/show/', [TypePieceIdentiteController::class, 'vw_liste'])->name('type_piece.show');
// Route::post('/type_piece/delete/{id}', [TypePieceIdentiteController::class, 'vw_delete'])->name('type_piece.delete');
// Route::get('/type_piece/delete/{id}', [TypePieceIdentiteController::class, 'vw_delete'])->name('type_piece.delete');
// Route::post('/type_piece/save', [TypePieceIdentiteController::class, 'vw_save'])->name('type_piece.save');
// Route::get('/type_piece/save', [TypePieceIdentiteController::class, 'vw_save'])->name('type_piece.save');

/**
*** TYPE_DEPLACEMENT
***/
// Route::post('/type_deplacement/show/', [TypeDeplacementController::class, 'vw_liste'])->name('type_deplacement.show');
// Route::get('/type_deplacement/show/', [TypeDeplacementController::class, 'vw_liste'])->name('type_deplacement.show');
// Route::post('/type_deplacement/delete/{id}', [TypeDeplacementController::class, 'vw_delete'])->name('type_deplacement.delete');
// Route::get('/type_deplacement/delete/{id}', [TypeDeplacementController::class, 'vw_delete'])->name('type_deplacement.delete');
// Route::post('/type_deplacement/save', [TypeDeplacementController::class, 'vw_save'])->name('type_deplacement.save');
// Route::get('/type_deplacement/save', [TypeDeplacementController::class, 'vw_save'])->name('type_deplacement.save');

/**
*** UE
***/
// Route::post('/ue/show/', [UEController::class, 'vw_liste'])->name('ue.show');
// Route::get('/ue/show/', [UEController::class, 'vw_liste'])->name('ue.show');
// Route::post('/ue/delete/{id}', [UEController::class, 'vw_delete'])->name('ue.delete');
// Route::get('/ue/delete/{id}', [UEController::class, 'vw_delete'])->name('ue.delete');
// Route::post('/ue/save', [UEController::class, 'vw_save'])->name('ue.save');
// Route::get('/ue/save', [UEController::class, 'vw_save'])->name('ue.save');

/**
*** USER
***/
// Route::post('/user/show/', [UserController::class, 'vw_liste'])->name('user.show');
// Route::get('/user/show/', [UserController::class, 'vw_liste'])->name('user.show');
// Route::post('/user/delete/{id}', [UserController::class, 'vw_delete'])->name('user.delete');
// Route::get('/user/delete/{id}', [UserController::class, 'vw_delete'])->name('user.delete');
// Route::post('/user/save', [UserController::class, 'vw_save'])->name('user.save');
// Route::get('/user/save', [UserController::class, 'vw_save'])->name('user.save');
// Route::post('/logout', [UserController::class, 'vw_logout'])->name('user.logout');
// Route::get('/logout', [UserController::class, 'vw_logout'])->name('user.logout');

/**
*** UNIVERSITE
***/
// Route::post('/universite/show/', [UniversiteController::class, 'vw_liste'])->name('universite.show');
// Route::get('/universite/show/', [UniversiteController::class, 'vw_liste'])->name('universite.show');
// Route::post('/universite/delete/{id}', [UniversiteController::class, 'vw_delete'])->name('universite.delete');
// Route::get('/universite/delete/{id}', [UniversiteController::class, 'vw_delete'])->name('universite.delete');
// Route::post('/universite/save', [UniversiteController::class, 'vw_save'])->name('universite.save');
// Route::get('/universite/save', [UniversiteController::class, 'vw_save'])->name('universite.save');
// Route::post('/universite/pg_choose', [UniversiteController::class, 'vw_pg_choose'])->name('universite.pg_choose');
// Route::get('/universite/pg_choose', [UniversiteController::class, 'vw_pg_choose'])->name('universite.pg_choose');

/**
*** ANNEE
***/
// Route::post('/annee/show/', [AnneeController::class, 'vw_liste'])->name('annee.show');
// Route::get('/annee/show/', [AnneeController::class, 'vw_liste'])->name('annee.show');
// Route::post('/annee/delete/{id}', [AnneeController::class, 'vw_delete'])->name('annee.delete');
// Route::get('/annee/delete/{id}', [AnneeController::class, 'vw_delete'])->name('annee.delete');
// Route::post('/annee/save', [AnneeController::class, 'vw_save'])->name('annee.save');
// Route::get('/annee/save', [AnneeController::class, 'vw_save'])->name('annee.save');
// Route::post('/annee/on_off/{id}', [AnneeController::class, 'vw_on_off'])->name('annee.on_off');
// Route::get('/annee/on_off/{id}', [AnneeController::class, 'vw_on_off'])->name('annee.on_off');
// Route::post('/annee/choose', [AnneeController::class, 'vw_choose'])->name('annee.choose');
// Route::get('/annee/choose', [AnneeController::class, 'vw_choose'])->name('annee.choose');

/**
*** RAPPORTS
***/
// Route::get('/rapport/scan2/', [ScanPresenceController::class, 'vw_liste2'])->name('rapport.scan2');
// Route::get('/rapport/scan/', [ScanPresenceController::class, 'vw_liste'])->name('rapport.scan');
// Route::post('/rapport/scan/', [ScanPresenceController::class, 'vw_liste'])->name('rapport.scan');
// Route::get('/rapport/delete/{id}', [ScanPresenceController::class, 'vw_delete'])->name('rapport.delete');
// Route::post('/rapport/delete/{id}', [ScanPresenceController::class, 'vw_delete'])->name('rapport.delete');

/**
*** ENSEIGNANT UE
***/
Route::post('/ens_ue/delete/{id}', [EnseignantUEController::class, 'vw_delete'])->name('ens_ue.delete');
Route::get('/ens_ue/delete/{id}', [EnseignantUEController::class, 'vw_delete'])->name('ens_ue.delete');
Route::post('/ens_ue/save', [EnseignantUEController::class, 'vw_save'])->name('ens_ue.save');
Route::get('/ens_ue/save', [EnseignantUEController::class, 'vw_save'])->name('ens_ue.save');
