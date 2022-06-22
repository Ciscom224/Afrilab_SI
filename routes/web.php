<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\APIReceptorController;
use App\Http\Controllers\LaboratoireController;
use App\Http\Controllers\PreparationController;
use App\Http\Controllers\receptionMailController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\DemandeAndEchantillonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[Controller::class,'home'])->name('home');

/******* admininistration*******/
Route::match(['get', 'post'],'/admin',[adminController::class,'adminPage'])->name('adminPage');
Route::match(['get', 'post'],'/generationRapport/{demande_id}',[adminController::class,'rapportGenere']);
Route::get('/formRapport/{demande_id}', [RapportController::class,'createPdf']);
Route::get('/exportRapport/{demande_id}', [RapportController::class,'exportRapport']);


/*******Recetion ROUTING*******/
Route::get('/reception',[ReceptionController::class,'reception'])->name('reception');
Route::match(['get','post'],'/demande/modification',[ReceptionController::class,'modificationPage'])->name('modification');
Route::match(['post','get'],'/Reception/demandeUpdate/{id}',[ReceptionController::class,'demandeUpdate']);
Route::post('/Reception/Ajoutdemande',[ReceptionController::class,'AjouterDemande'])->name('ajoutDemande');
Route::get('/Reception/delete/{id}',[ReceptionController::class,'delete']);
Route::get('/Reception/upadtePage/{id}',[ReceptionController::class,'updatePage']);
Route::post('/Reception/update',[ReceptionController::class,'update']);
Route::post('/Reception/store',[ReceptionController::class,'store']);

Route::get('/Reception/ajouterEchantillon/{demande_id}',[ReceptionController::class,'ajouterEchantillon']);
Route::post('/Reception/echantillons/demande/{damande_path}',[ReceptionController::class,'AjouterDesEchantillons'])->name('AjouterDesEchantillons');
Route::get('/AppLogin',[PreparationController::class,'loginPage'])->name('login');

/*******services ROUTING*******/
Route::get('/reception/echantillon/save/{demande_id}',[ReceptionController::class,'echantillonPage']);


/********************Preparation  ROUTING******************/
Route::get('/preparation/{name}',[PreparationController::class,'showPage'])->name('preparation');
// -----------------------Preparation chimique------------------------------------
Route::get('/Préparation/Chimique',[PreparationController::class,'homePagePC'])->name('homePagePC');
Route::get('/Préparation/Chimique/detatils/demande/{demande_id}',[PreparationController::class,'demandeDetails']);
Route::get('/Préparation/Chimique/detatils/demande/edit/{demande_id}',[PreparationController::class,'demandeEdit']);
Route::post('/Préparation/Chimique/demande/edit',[PreparationController::class,'demandeUpdate']);
Route::post('/Préparation/Chimique/MasseVolume/{demande_id}',[PreparationController::class,'demandeAddMasseVolume']);
Route::get('/Préparation/Chimique/demande/envoyer/{demande_id}',[PreparationController::class,'validerDemandePc']);
// registre humidite
Route::match(['post','get'],'/Préparation/Chimique/Registre/humidite',[PreparationController::class,'humiditeHome']);
Route::match(['post','get'],'/Préparation/Chimique/RegistreAdd/humidite',[PreparationController::class,'addRegistreHumidite']);
Route::get('/registreHumiditeAll',[PreparationController::class,'indexRegistreHumidite']);
Route::get('/registreHumidite/{demande_id}',[PreparationController::class,'createHumidite']);
Route::match(['post','get'],'/Préparation/Chimique/RegistreAdd/humidite',[PreparationController::class,'addRegistreHumidite']);

//---------------------------------------------------------------------------------------------------------------------
// registre densite
Route::match(['post','get'],'/Préparation/Chimique/Registre/densite',[PreparationController::class,'densiteHome']);
Route::match(['post','get'],'/Préparation/Chimique/RegistreAdd/densite',[PreparationController::class,'addRegistreDensite']);
Route::get('/registreDensiteAll',[PreparationController::class,'indexRegistreDensite']);
Route::get('/registreDensite/{demande_id}',[PreparationController::class,'createDensite']);

//-------------------------------------------------------------------------------------------------------
// registre perte feu
Route::match(['post','get'],'/Préparation/Chimique/Registre/pertefeu',[PreparationController::class,'pertefeuHome']);
Route::match(['post','get'],'/Préparation/Chimique/RegistreAdd/pertefeu',[PreparationController::class,'addRegistrePertefeu']);
Route::get('/registrePertefeuAll',[PreparationController::class,'indexRegistrePertefeu']);
Route::get('/registrepertefeu/{demande_id}',[PreparationController::class,'createPertfeu']);

Route::get('/Preparation/Volumetrie/Registre/',[LaboratoireController::class,'indexRegistreVolumetrie']);

//-------------------------------------------------------------------------------------------------------

// ---------------preparation mecanique-----------------------------------
Route::get('/validationMecanique/{demande_id}',[PreparationController::class,'validationMecanique']);
Route::get('/Préparation/Mecanique',[PreparationController::class,'homePagePM'])->name('homePagePM');

// ---------------------volumetrie---------------------
Route::match(['get','post'],'laboratoire/Volumetrie',[LaboratoireController::class,'homeVolumetrie'])->name('homeVolumetrie');
Route::get('/Labortoire/Volumetrie/detatils/demande/{demande_id}',[LaboratoireController::class,'demandeDetailsVolumetrie']);
Route::match(['get','post'],'/Laboratoire/volumetrie/RegistreAdd/{demande_id}',[LaboratoireController::class,'addRegistre']);
Route::match(['get','post'],'/Labortoire/Volumetrie/detatils/demande/addTemoin/volumetrie/{demande_id}',[LaboratoireController::class,'addTemoinVolumetrie']);
Route::match(['get','post'],'/Labortoire/Volumetrie/demande/envoie/{demande_id}',[LaboratoireController::class,'validerDemandeVolumetrie']);
Route::match(['get','post'],'/Labortoire/Volumetrie/demande/autreEssaie',[LaboratoireController::class,'essaieVolumetrie']);
Route::match(['get','post'],'Labortoire/Volumetrie/demande/addEssai',[LaboratoireController::class,'addEssaie']);
// ----------------------absorption---------------------
Route::get('laboratoire/Absorption',[LaboratoireController::class,'homeAbsorption'])->name('homeAbsorption');
Route::get('/Labortoire/Absorption/details/demande/{demande_id}',[LaboratoireController::class,'demandeDetailsAbsorption']);
Route::get('/Labortoire/Absorption/envoie/demande/{demande_id}',[LaboratoireController::class,'validerDemandeAbsorption']);
Route::match(['get','post'],'/Labortoire/Absorption/demande/element/{element}',[LaboratoireController::class,'resultAA']);
Route::post('/Labortoire/Absorption/details/demande/addTemoinAA/{demande_id}',[LaboratoireController::class,'addTemoin']);
// ----------------------ICP---------------------
Route::get('/laboratoire/ICP',[LaboratoireController::class,'homeICP'])->name('homeICP');
Route::match(['post','get'],'/Laboratoire/ICP/demande',[LaboratoireController::class,'showDemandeIcp']);
Route::post('/importFileXlsx', [LaboratoireController::class,'import']);
// ----------------administration --------------------------------------
Route::match(['get','post'],'/administrationRT/index',[adminController::class,'adminRT'])->name('adminRT');
Route::match(['get', 'post'],'/administration/detatils/demande/{demande_id}',[adminController::class,'details']);
Route::match(['get', 'post'],'/administration/addEmploye',[adminController::class,'ajoutEmploye']);

/*******ReadFile API *******/
Route::get('/laboratoire/readFile',[LaboratoireController::class,'readFile']);
Route::match(['post','get'],'/addData',[LaboratoireController::class,'addDataFromFile']);
Route::match(['post','get'],'/page404',[ReceptionController::class,'page404']);




/*******Receptor API ROUTING*******/
Route::match(['post','get'],'/connexion/{page}',[APIReceptorController::class,'login'])->name('login');
Route::get('/isLoggedIn',[APIReceptorController::class,'isLoggedIn'])->name('isLoggedIn');
Route::get('/logout',[APIReceptorController::class,'logout'])->name('logout');
Route::get('/bar',[receptionMailController::class,'bar'])->name('bar');


/***********Demande API ROUTE***** */


Route::get('/demande/deleteDemande/{demande_id}',[DemandeAndEchantillonController::class,'deleteDemande'])->name('deleteDemande');
Route::get('/echantillonsUpdate',[DemandeAndEchantillonController::class,'updateEchantillon'])->name('updateEchantillon');

Route::get('/getDemande',[DemandeAndEchantillonController::class,'getDemande'])->name('getDemande');

// -------------------routing for management employe-----------------
Route::get('/admin/employe/create',[EmployeController::class,'create']);
Route::post('/admin/employe/store',[EmployeController::class,'store']);
