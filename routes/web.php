<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


//Home Routes

Route::get('/',[HomeController::class, 'index'])->name('index');


//About  Menu
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/history', [HomeController::class, 'history'])->name('history');
Route::get('/sufism', [HomeController::class, 'sufism'])->name('sufism');
Route::get('/hajiwarisalishah', [HomeController::class, 'hajiwarisalishah'])->name('hajiwarisalishah');
Route::get('/mazar', action: [HomeController::class, 'mazar'])->name(name: 'mazar');
Route::get('/qurbanalishah', [HomeController::class, 'qurbanalishah'])->name('qurbanalishah');
Route::get('/badelamazar', action: [HomeController::class, 'badelamazar'])->name(name: 'badelamazar');
Route::get('/shahwilayatshah', [HomeController::class, 'shahwilayatshah'])->name('shahwilayatshah');
Route::get('/shahwilayatmazar', action: [HomeController::class, 'shahwilayatmazar'])->name(name: 'shahwilayatmazar');
Route::get('/raheemshah', [HomeController::class, 'raheemshah'])->name('raheemshah');
Route::get('/raheemshahmazar', action: [HomeController::class, 'raheemshahmazar'])->name(name: 'raheemshahmazar');
Route::get('/faizushah', [HomeController::class, 'faizushah'])->name('faizushah');
Route::get('/faizushahmazar', action: [HomeController::class, 'faizushahmazar'])->name(name: 'faizushahmazar');
Route::get('/mosquedargah', [HomeController::class, 'mosquedargah'])->name('mosquedargah');
Route::get('/wazukhana', [HomeController::class, 'wazukhana'])->name('wazukhana');
Route::get('/langarkhana', [HomeController::class, 'langarkhana'])->name('langarkhana');
Route::get('/samakhana', [HomeController::class, 'samakhana'])->name('samakhana');
Route::get('/qawwaliplace', [HomeController::class, 'qawwaliplace'])->name('qawwaliplace');
Route::get('/trustoffice', [HomeController::class, 'trustoffice'])->name('trustoffice');
Route::get('/mela', [HomeController::class, 'mela'])->name('mela');
Route::get('/numaisground', [HomeController::class, 'numaisground'])->name('numaisground');
Route::get('/auditorium', [HomeController::class, 'auditorium'])->name('auditorium');
Route::get('/eidgaah', [HomeController::class, 'eidgaah'])->name('eidgaah');
Route::get('/culture', [HomeController::class, 'artandculture'])->name('artandculture');
Route::get('/artandcraft', [HomeController::class, 'artandcraft'])->name('artandcraft');
Route::get('/guesthouse', [HomeController::class, 'guesthouse'])->name(name: 'guesthouse');
Route::get('/madarsalist', [HomeController::class, 'madarsalist'])->name(name: 'madarsalist');
Route::get('/education', [HomeController::class, 'collegeslist'])->name('collegeslist');
Route::get('/hospitals', [HomeController::class, 'hospitals'])->name(name: 'hospitals');
Route::get('/docters', [HomeController::class, 'docters'])->name(name: 'docters');
Route::get('/banks', [HomeController::class, 'bank'])->name('bank');
Route::get('/thana', [HomeController::class, 'thana'])->name('thana');
Route::get('/postoffice', [HomeController::class, 'postoffice'])->name(name: 'postoffice');
Route::get('/townarea', [HomeController::class, 'townarea'])->name('townarea');
Route::get('/safayiheroes', [HomeController::class, 'safayiheroes'])->name('safayiheroes');



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Aulia-Allah
Route::get('/abdulqadirgilani', [HomeController::class, 'baghdad'])->name('abdulqadirgilani');
Route::get('/muinuddinchisti', [HomeController::class, 'ajmer'])->name('muinuddinchisti');
Route::get('/hazratnizamuddin', [HomeController::class, 'delhi'])->name('hazratnizamuddin');
Route::get('/hajiali', [HomeController::class, 'mumbai'])->name('hajiali');
Route::get('/syedmasoodghazi', [HomeController::class, 'bahraich'])->name(name: 'syedmasoodghazi');
Route::get('/syedmakhdoom', [HomeController::class, 'kichhauchha'])->name(name: 'syedmakhdoom');
Route::get('/aalahazrat', [HomeController::class, 'bareilly'])->name('aalahazrat');
Route::get('/hazratbal', [HomeController::class, 'srinagar'])->name('hazratbal');
Route::get('/hazrattajuddin', [HomeController::class, 'nagpur'])->name(name: 'hazrattajuddin');
Route::get('/shahmeenashah', [HomeController::class, 'shahmeenashah'])->name('shahmeenashah');
Route::get('/khammanpeer', [HomeController::class, 'khammanpeer'])->name('khammanpeer');
Route::get('/dataganjbaksh', [HomeController::class, 'lahore'])->name('dataganjbaksh');
// Route::get('/', [HomeController::class, ''])->name('');


// AhleBayt-Sahaba
 Route::get('/muhammad', [HomeController::class, 'mohammad'])->name('muhammad');
 Route::get('/fatima', [HomeController::class, 'fatima'])->name('fatima');
 Route::get('/ali', [HomeController::class, 'ali'])->name('ali');
 Route::get('/hasan', [HomeController::class, 'hasan'])->name('hasan');
 Route::get('/hussain', [HomeController::class, 'hussain'])->name('husain');
 Route::get('/khadija', [HomeController::class, 'khadija'])->name('khadija');
 Route::get('/aisha', [HomeController::class, 'aisha'])->name('aisha');
 Route::get('/hafsa', [HomeController::class, 'hafsa'])->name('hafsa');
 Route::get('/ummesalma', [HomeController::class, 'ummesalma'])->name('ummesalma');
 Route::get('/abbas', [HomeController::class, 'abbas'])->name('abbas');
 Route::get('/jafar', [HomeController::class, 'jafar'])->name('jafar');
 Route::get('/abubakrsiddiq', [HomeController::class, 'abubakrsiddiq'])->name('abubakrsiddiq');
 Route::get('/umar', [HomeController::class, 'umar'])->name('umar');
 Route::get('/usman', [HomeController::class, 'usman'])->name('usman');
 Route::get('/sawdah', [HomeController::class, 'sawdah'])->name('sawdah');
 Route::get('/', [HomeController::class, ''])->name('');
 Route::get('/zaynabbintkhuzayma', [HomeController::class, 'zaynabbintkhuzayma'])->name('zaynabbintkhuzayma');
 Route::get('/juwayriyahbintalharis', [HomeController::class, 'juwayriyahbintalharis'])->name('juwayriyahbintalharis');
 Route::get('/zaynabbintjahsh', [HomeController::class, 'zaynabbintjahsh'])->name('zaynabbintjahsh');
 Route::get('/ummhabibahbintabisufyan', [HomeController::class, 'ummhabibahbintabisufyan'])->name('ummhabibahbintabisufyan');
 Route::get('/maymonahbintalharis', [HomeController::class, 'maymonahbintalharis'])->name('maymonahbintalharis');
 Route::get('/safiyyahbinthuyayyibnakhtab', [HomeController::class, 'safiyyahbinthuyayyibnakhtab'])->name('safiyyahbinthuyayyibnakhtab');
//  Route::get('/', [HomeController::class, ''])->name('');


// ***ISLAM***//

//makkah-al-mukarrama
Route::get('/allah', [HomeController::class, 'creater'])->name('allah');
Route::get('/hazratmuhammad', [HomeController::class, 'messenger'])->name('hazratmuhammad');
Route::get('/islam', [HomeController::class, 'islam'])->name('islam');
Route::get('/makkah', [HomeController::class, 'makkah'])->name('makkah');
Route::get('/khanaekaaba', [HomeController::class, 'khanaekaaba'])->name('khanaekaaba');
Route::get('/alharammosque', [HomeController::class, 'alharammosque'])->name('alharammosque');
Route::get('/alhajaralaswad', [HomeController::class, 'alhajaralaswad'])->name('alhajaralaswad');
Route::get('/alsafaalmarwa', [HomeController::class, 'alsafaalmarwa'])->name(name: 'alsafaalmarwa');
Route::get('/zamzam', [HomeController::class, 'zamzam'])->name('zamzam');
Route::get('/makameibraheem', [HomeController::class, 'makameibraheem'])->name(name: 'makameibraheem');
Route::get('/thekiswafactory', [HomeController::class, 'thekiswafactory'])->name('thekiswafactory');
Route::get('/clocktower', [HomeController::class, 'clocktower'])->name('clocktower');
Route::get('/exhibitionmosques', [HomeController::class, 'exhibitionmosques'])->name('exhibitionmosques');
Route::get('/hajj', [HomeController::class, 'hajj'])->name('hajj');
Route::get('/umrah', [HomeController::class, 'umrah'])->name('umrah');
Route::get('/alrahmatmountain', [HomeController::class, 'alrahmatmountain'])->name('alrahmatmountain');
Route::get('/alnoormountain', [HomeController::class, 'alnoormountain'])->name('alnoormountain');
Route::get('/altoormountain', [HomeController::class, 'altoormountain'])->name('altoormountain');
Route::get('/arafat', [HomeController::class, 'arafat'])->name('arafat');
Route::get('/alqubaismountain', [HomeController::class, 'alqubaismountain'])->name(name: 'alqubaismountain');
Route::get('/mina', [HomeController::class, 'mina'])->name('mina');
Route::get('/muzdalifa', [HomeController::class, 'muzdalifa'])->name('muzdalifa');
Route::get('/jisraljamarat', [HomeController::class, 'jisraljamarat'])->name('jisraljamarat');
Route::get('/jannatalmualla', [HomeController::class, 'jannatalmualla'])->name('jannatalmualla');
Route::get('/badr', [HomeController::class, 'badr'])->name('badr');
Route::get('/birtuwawell', [HomeController::class, 'birtuwawell'])->name('birtuwawell');
Route::get('/makkahmuseum', [HomeController::class, 'makkahmusium'])->name('makkahmuseum');
Route::get('/bilalbinrabahmosque', [HomeController::class, 'bilalbinrabahmosque'])->name('bilalbinrabahmosque');
Route::get('/aishamosque', [HomeController::class, 'aishamosque'])->name(name: 'aishamosque');
Route::get('/nimrahmosque', [HomeController::class, 'nimrahmosque'])->name('nimrahmosque');
Route::get('/aishaalrajhimosque', [HomeController::class, 'aishaalrajhimosque'])->name(name: 'aishaalrajhimosque');
Route::get('/alrayahmosque', [HomeController::class, 'alrayahmosque'])->name('alrayahmosque');
Route::get('/alkhaifmosque', [HomeController::class, 'alkhaifmosque'])->name('alkhaifmosque');
Route::get('/aljinnmosque', [HomeController::class, 'aljinnmosque'])->name('aljinnmosque');
Route::get('/gharehira', [HomeController::class, 'gharehira'])->name('gharehira');
Route::get('/zamzamwell', [HomeController::class, 'zamzamwell'])->name('zamzamwell');


//ALMadinahAlMunawwara
Route::get('muhammad', [HomeController::class, 'muhammad'])->name('muhammad');
Route::get('/hazratmuhammaddome', [HomeController::class, 'hazratmuhammaddome'])->name('hazratmuhammaddome');
Route::get('madinah', [HomeController::class, 'madinah'])->name('madinah');
Route::get('/almasjidalnabawi', [HomeController::class, 'almasjidalnabawi'])->name('almasjidalnabawi');
Route::get('/jannatulbaque', [HomeController::class, 'jannatulbaqi'])->name('jannatulbaque');
Route::get('/alqubamosque', [HomeController::class, 'alqubamosque'])->name(name: 'alqubamosque');
Route::get('/alqiblataynmosque', [HomeController::class, 'alqiblataynmosque'])->name(name: 'alqiblataynmosque');
Route::get('/mountuhud', [HomeController::class, 'mountuhud'])->name('mountuhud');
Route::get('/ghamamahmosque', [HomeController::class, 'ghamamahmosque'])->name('ghamamahmosque');
Route::get('/abubakrmosque', [HomeController::class, 'abubakrmosque'])->name('abubakrmosque');
Route::get('/albidyamosque', [HomeController::class, 'anbariyamosque'])->name(name: 'albidyamosque');
Route::get('/wadiejinn', [HomeController::class, 'wadiejinn'])->name('wadiejinn');
Route::get('/jumahmosque', [HomeController::class, 'jumahmosque'])->name('jumahmosque');
Route::get('/almadinahmuseum', [HomeController::class, 'almadinahmuseum'])->name('almadinahmuseum');
Route::get('/daralmadinahmuseum', [HomeController::class, 'daralmadinahmuseum'])->name('daralmadinahmuseum');
Route::get('/hejazrailwaymuseum', [HomeController::class, 'hejazrailwaymuseum'])->name('hejazrailwaymuseum');
Route::get('/quranprintcomplex', [HomeController::class, 'quranprintcomplex'])->name('quranprintcomplex');

// Gellary
Route::get('/gellary', [HomeController::class, 'gellary'])->name('gellary');
