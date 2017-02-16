<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Menu;
use App\Models\MenuKonten;
use Auth;
use Validator;

class ManajemenMenuController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getmain = Menu::where([['level', 1],['id_skpd', null]])->get();
      $getmenu = Menu::where('id_skpd', null)->get();
      $getparent = Menu::where('id_skpd', null)->get();;
    } else {
      $getmain = Menu::where([['level', 1],['id_skpd', Auth::user()->masterskpd->id]])->get();
      $getmenu = Menu::where('id_skpd', Auth::user()->masterskpd->id)->get();
      $getparent = Menu::where('id_skpd', Auth::user()->masterskpd->id)->get();;
    }

    return view('backend/pages/kelolamenu')
      ->with('getparent', $getparent)
      ->with('getmenu', $getmenu)
      ->with('getmain', $getmain);
  }

  public function store(Request $request)
  {
    if (Auth::user()->level=="1") {
      $checklimitation = Menu::where('level', 1)->where('id_skpd', null)->count();
      if ($checklimitation>=3) {
        return redirect()->route('menu.index')->with('messagefail', 'Main menu tidak dapat ditambah. Limit jumlah main menu adalah 3.');
      }

      if ($request->level=="1") { //jika menu adalah main menu
        $messages = [
          'nama.required' => 'Tidak boleh kosong.',
          'level.required' => 'Tidak boleh kosong.',
          'level.not_in' => 'Pilih salah satu.',
        ];

        $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'level' => 'required|not_in:-- Pilih --',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->route('menu.index')
                            ->withErrors($validator)
                            ->withInput();
            }

        $set = new Menu;
        $set->nama = $request->nama;
        $set->level = $request->level;
        if ($request->linkmainmenu!="") {
          $set->linkmainmenu = "http://".$request->linkmainmenu;
        }
        $set->save();
      } else {
        $messages = [
          'nama.required' => 'Tidak boleh kosong.',
          'level.required' => 'Tidak boleh kosong.',
          'level.not_in' => 'Pilih salah satu.',
          'parent_menu.not_in' => 'Pilih salah satu.',
        ];

        $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'level' => 'required|not_in:-- Pilih --',
                'parent_menu' => 'required|not_in:000',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->route('menu.index')
                            ->withErrors($validator)
                            ->withInput();
            }

        $set = new Menu;
        $set->nama = $request->nama;
        $set->level = $request->level;
        $set->parent_menu = $request->parent_menu;
        $set->save();
      }
    } else {
      $checklimitation = Menu::where('level', 1)->where('id_skpd', Auth::user()->id_skpd)->count();
      if ($checklimitation>=3) {
        return redirect()->route('menu.index')->with('messagefail', 'Main menu tidak dapat ditambah. Limit jumlah main menu adalah 3.');
      }

      if ($request->level=="1") { //jika menu adalah main menu
        $messages = [
          'nama.required' => 'Tidak boleh kosong.',
          'level.required' => 'Tidak boleh kosong.',
          'level.not_in' => 'Pilih salah satu.',
        ];

        $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'level' => 'required|not_in:-- Pilih --',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->route('menu.index')
                            ->withErrors($validator)
                            ->withInput();
            }

        $set = new Menu;
        $set->nama = $request->nama;
        $set->level = $request->level;
        if ($request->linkmainmenu!="") {
          $set->linkmainmenu = "http://".$request->linkmainmenu;
        }
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      } else {
        $messages = [
          'nama.required' => 'Tidak boleh kosong.',
          'level.required' => 'Tidak boleh kosong.',
          'level.not_in' => 'Pilih salah satu.',
          'parent_menu.not_in' => 'Pilih salah satu.',
        ];

        $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'level' => 'required|not_in:-- Pilih --',
                'parent_menu' => 'required|not_in:000',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->route('menu.index')
                            ->withErrors($validator)
                            ->withInput();
            }

        $set = new Menu;
        $set->nama = $request->nama;
        $set->level = $request->level;
        $set->parent_menu = $request->parent_menu;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    }

    return redirect()->route('menu.index')->with('message', 'Berhasil menambahkan menu.');
  }

  public function delete($id)
  {
    $check = MenuKonten::where('id_submenu', $id)->count();
    if ($check == 0) {
      $set = Menu::find($id);
      $set->delete();

      return redirect()->route('menu.index')->with('message', 'Berhasil menambahkan menu.');
    } else {
      return redirect()->route('menu.index')->with('messagefail', 'Menu tidak dapat di hapus karena telah memiliki konten.');
    }
  }

  public function bind($id)
  {
    $get = Menu::find($id);
    return $get;
  }
}
