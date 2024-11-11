<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    //dewa sharif

    public function about()
    {
        return view('home.dewa.about');
    }

    public function history()
    {
        return view('home.dewa.history');
    }

    public function sufism()
    {
        return view('home.dewa.sufism');
    }

    public function hajiwarisalishah()
    {
        return view('home.dewa.hajiwarisalishah');
    }

    public function mazar()
    {
        return view('home.dewa.mazar');
    }

    public function qurbanalishah()
    {
        return view('home.dewa.qurbanalishah');
    }

    public function badelamazar()
    {
        return view('home.dewa.badelamazar');
    }

    public function shahwilayatshah()
    {
        return view('home.dewa.shahwilayatshah');
    }

    public function shahwilayatmazar()
    {
        return view('home.dewa.shahwilayatmazar');
    }

    public function raheemshah()
    {
        return view('home.dewa.raheemshah');
    }

    public function raheemshahmazar()
    {
        return view('home.dewa.raheemshahmazar');
    }

    public function faizushah()
    {
        return view('home.dewa.faizushah');
    }



    public function faizushahmazar()
    {
        return view('home.dewa.faizushahmazar');
    }

    public function mosqueDargah()
    {
        return view('home.dewa.mosquedargah');
    }

    public function wazukhana()
    {
        return view('home.dewa.wazukhana');
    }


    public function samakhana()
    {
        return view('home.dewa.samakhana');
    }

    public function qawwaliplace()
    {
        return view('home.dewa.qawwaliplace');
    }

    public function langarkhana()
    {
        return view('home.dewa.langarkhana');
    }

    public function trustoffice()
    {
        return view('home.dewa.trustoffice');
    }

    public function mela()
    {
        return view('home.dewa.mela');
    }

    public function numaisground()
    {
        return view('home.dewa.numaisground');
    }

    public function auditorium()
    {
        return view('home.dewa.auditorium');
    }

    public function eidgaah()
    {
        return view('home.dewa.eidgaah');
    }

    public function artandculture()
    {
        return view('home.dewa.artandculture');
    }

    public function artandcraft()
    {
        return view('home.dewa.artandcraft');
    }

    public function guesthouse()
    {
        return view('home.dewa.guesthouse');
    }

    public function madarsalist()
    {
        return view('home.dewa.madarsalist');
    }

    public function collegeslist()
    {
        return view('home.dewa.collegeslist');
    }

    public function hospitals()
    {
        return view('home.dewa.hospitals');
    }

    public function docters()
    {
        return view('home.dewa.docters');
    }

    public function bank()
    {
        return view('home.dewa.bank');
    }

    public function thana()
    {
        return view('home.dewa.thana');
    }

    public function postoffice()
    {
        return view('home.dewa.postoffice');
    }

    public function townarea()
    {
        return view('home.dewa.townarea');
    }

    public function safayiheroes()
    {
        return view('home.dewa.safayiheroes');
    }


    // Aulia-Allah

    public function baghdad()
    {
        return view('home.buzurganeislam.auliaallah.abdulqadirgilani');
    }

    public function khammanpeer()
    {
        return view('home.buzurganeislam.auliaallah.khammanpeer');
    }

    public function shahmeenashah()
    {
        return view('home.buzurganeislam.auliaallah.shahmeenashah');
    }

    public function lahore()
    {
        return view('home.buzurganeislam.auliaallah.dataganjbaksh');
    }

    public function delhi()
    {
        return view('home.buzurganeislam.auliaallah.hazratnizamuddin');
    }

    public function ajmer()
    {
        return view('home.buzurganeislam.auliaallah.muinuddinchisti');
    }

    public function mumbai()
    {
        return view('home.buzurganeislam.auliaallah.hajiali');
    }

    public function nagpur()
    {
        return view('home.buzurganeislam.auliaallah.hazrattajuddin');
    }

    public function bahraich()
    {
        return view('home.buzurganeislam.auliaallah.syedmasoodghazi');
    }


    public function kichhauchha()
    {
        return view('home.buzurganeislam.auliaallah.syedmakhdoom');
    }

    public function srinagar()
    {
        return view('home.buzurganeislam.auliaallah.hazratbal');
    }

    public function bareilly()
    {
        return view('home.buzurganeislam.auliaallah.aalahazrat');
    }


// Ahlebayt-Sahaba
public function mohammad()
{
    return view('home.buzurganeislam.ahlebaytsahaba.muhammad');
}

public function fatima()
{
    return view('home.buzurganeislam.ahlebaytsahaba.fatima');
}

public function ali()
{
    return view('home.buzurganeislam.ahlebaytsahaba.ali');
}

public function hasan()
{
    return view('home.buzurganeislam.ahlebaytsahaba.hasan');
}

public function hussain()
{
    return view('home.buzurganeislam.ahlebaytsahaba.husain');
}

public function khadija()
{
    return view('home.buzurganeislam.ahlebaytsahaba.khadija');
}

public function sawdah()
{
    return view('home.buzurganeislam.ahlebaytsahaba.sawdahbintzamah');
}

public function aisha()
{
    return view('home.buzurganeislam.ahlebaytsahaba.aisha');
}

public function hafsa()
{
    return view('home.buzurganeislam.ahlebaytsahaba.hafsa');
}

public function ummesalma()
{
    return view('home.buzurganeislam.ahlebaytsahaba.ummesalma');
}

public function zaynabbintkhuzayma()
{
    return view('home.buzurganeislam.ahlebaytsahaba.zaynabbintkhuzayma');
}

public function juwayriyahbintalharis()
{
    return view('home.buzurganeislam.ahlebaytsahaba.juwayriyahbintalharis');
}
public function zaynabbintjahsh()
{
    return view('home.buzurganeislam.ahlebaytsahaba.zaynabbintjahsh');
}
public function ummhabibahbintabisufyan()
{
    return view('home.buzurganeislam.ahlebaytsahaba.ummhabibahbintabisufyan');
}
public function maymonahbintalharis()
{
    return view('home.buzurganeislam.ahlebaytsahaba.maymonahbintalharis');
}
public function safiyyahbinthuyayyibnakhtab()
{
    return view('home.buzurganeislam.ahlebaytsahaba.safiyyahbinthuyayyibnakhtab');
}

public function abbas()
{
    return view('home.buzurganeislam.ahlebaytsahaba.abbas');
}

public function jafar()
{
    return view('home.buzurganeislam.ahlebaytsahaba.jafar');
}

public function abubakrsiddiq()
{
    return view('home.buzurganeislam.ahlebaytsahaba.abubakr');
}

public function umar()
{
    return view('home.buzurganeislam.ahlebaytsahaba.umar');
}

public function usman()
{
    return view('home.buzurganeislam.ahlebaytsahaba.usman');
}






    // ISLAM ************

    // MAKKAH Al Mukarrama

    public function creater()
    {
        return view('home.islam.makkah.allah');
    }

    public function messenger()
    {
        return view('home.islam.makkah.hazratmuhammad');
    }

    public function islam()
    {
        return view('home.islam.makkah.islam');
    }

    public function makkah()
    {
        return view('home.islam.makkah.makkah');
    }

    public function khanaekaaba()
    {
        return view('home.islam.makkah.khanaekaaba');
    }

    public function alharammosque()
    {
        return view('home.islam.makkah.alharammosque');
    }

    public function alhajaralaswad()
    {
        return view('home.islam.makkah.alhajaralaswad');
    }

    public function alsafaalmarwa()
    {
        return view('home.islam.makkah.alsafaalmarwa');
    }

    public function zamzam()
    {
        return view('home.islam.makkah.zamzam');
    }

    public function makameibraheem()
    {
        return view('home.islam.makkah.makameibraheem');
    }

    public function thekiswafactory()
    {
        return view('home.islam.makkah.thekiswafactory');
    }

    public function clocktower()
    {
        return view('home.islam.makkah.clocktower');
    }

    public function exhibitionmosques()
    {
        return view('home.islam.makkah.exhibitionmosques');
    }


    public function hajj()
    {
        return view('home.islam.makkah.hajj');
    }

    public function umrah()
    {
        return view('home.islam.makkah.umrah');
    }

    public function alrahmatmountain()
    {
        return view('home..islam.makkah.alrahmatmountain');
    }

    public function alnoormountain()
    {
        return view('home.islam.makkah.alnoormountain');
    }

    public function altoormountain()
    {
        return view('home.islam.makkah.altoormountain');
    }

    public function arafat()
    {
        return view('home.islam.makkah.arafat');
    }

    public function alqubaismountain()
    {
        return view('home.islam.makkah.alqubaismountain');
    }


    public function mina()
    {
        return view('home.islam.makkah.mina');
    }

    public function muzdalifa()
    {
        return view('home.islam.makkah.muzdalifa');
    }

    public function jisraljamarat()
    {
        return view('home.islam.makkah.jisraljamarat');
    }

    public function jannatalmualla()
    {
        return view('home.islam.makkah.jannatalmualla');
    }

    public function badr()
    {
        return view('home.islam.makkah.badr');
    }

    public function birtuwawell()
    {
        return view('home.islam.makkah.birtuwawell');
    }

    public function makkahmusium()
    {
        return view('home.islam.makkah.makkahmusium');
    }

    public function bilalbinrabahmosque()
    {
        return view('home.islam.makkah.bilalbinrabahmosque');
    }

    public function aishamosque()
    {
        return view('home.islam.makkah.aishamosque');
    }



    public function nimrahmosque()
    {
        return view('home.islam.makkah.nimrahmosque');
    }

    public function aishaalrajhimosque()
    {
        return view('home.islam.makkah.aishaalrajhimosque');
    }

    public function alrayahmosque()
    {
        return view('home.islam.makkah.alrayahmosque');
    }

    public function alkhaifmosque()
    {
        return view('home..islam.makkah.alkhaifmosque');
    }

    public function aljinnmosque()
    {
        return view('home.islam.makkah.aljinnmosque');
    }

    public function gharehira()
    {
        return view('home..islam.makkah.gharehira');
    }

    public function zamzamwell()
    {
        return view('home..islam.makkah.zamzamwell');
    }


    // MADINAH Al Munawwara

    public function muhammad()
    {
        return view('home.islam.madina.muhammad');
    }

    public function hazratmuhammaddome()
    {
        return view('home.islam.madina.hazratmuhammaddome');
    }

    public function madinah()
    {
        return view('home.islam.madina.madinah');
    }

    public function almasjidalnabawi()
    {
        return view('home.islam.madina.almasjidalnabawi');
    }

    public function jannatulbaqi()
    {
        return view('home.islam.madina.jannatulbaqi');
    }

    public function alqubamosque()
    {
        return view('home.islam.madina.alqubamosque');
    }

    public function alqiblataynmosque()
    {
        return view('home.islam.madina.alqiblataynmosque');
    }

    public function mountuhud()
    {
        return view('home.islam.madina.mountuhud');
    }

    public function ghamamahmosque()
    {
        return view('home.islam.madina.ghamamahmosque');
    }

    public function abubakrmosque()
    {
        return view('home.islam.madina.abubakrmosque');
    }

    public function anbariyamosque()
    {
        return view('home.islam.madina.anbariyamosque');
    }

    public function wadiejinn()
    {
        return view('home.islam.madina.wadiejinn');
    }

    public function jumahmosque()
    {
        return view('home.islam.madina.jumahmosque');
    }

    public function daralmadinahmuseum()
    {
        return view('home.islam.madina.daralmadinahmuseum');
    }

    public function hejazrailwaymuseum()
    {
        return view('home.islam.madina.hejazrailwaymuseum');
    }

    public function quranprintcomplex()
    {
        return view('home.islam.madina.quranprintcomplex');
    }

    public function almadinahmuseum()
    {
        return view('home.islam.madina.almadinahmuseum');
    }

// Instructions

public function copyright()
{
    return view('home.instructions.copyright');
}

public function disclaimer()
{
    return view('home.instructions.disclaimer');
}
public function privacy()
{
    return view('home.instructions.privacy');
}
public function terms()
{
    return view('home.instructions.terms');
}

// Quick Links
public function dosanddonts()
{
    return view('home.links.dosanddonts');
}
public function faqs()
{
    return view('home.links.faqs');
}

// Gellary


    public function gellary()
    {
        return view('home.gellary.gellary');
    }
}
