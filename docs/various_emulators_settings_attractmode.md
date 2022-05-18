* * * * *\
**> AMIGA 500**

executable           C:\attract\EMU\amiga\System\FS-UAE\Windows\x86-64\fs-uae.exe\
args                 --floppy-drive-0="[romfilename]" --fullscreen --floppy-drive-0-sounds=0 --floppy-drive-speed=100 --floppy-drive-volume-empty=100  --base-dir="C:\attract\EMU\amiga\Configuration"\
rompath              C:\attract\EMU\amiga\roms\
romext               .adf\
system               Amiga\
info_source          thegamesdb.net\
exit_hotkey          Escape

Note : for portable Version, create a configuration folder and set it as base-dir-parameter

* * * * *\
**> AMIGA CD32**

executable           C:\attract\EMU\AMIGA CD32\System\FS-UAE\Windows\x86-64\fs-uae.exe\
args                 --amiga-model=CD32 --fast-memory=8192 --cdrom-drive-0="[romfilename]" --fullscreen --base-dir="C:\attract\EMU\Amiga CD32\Configuration"\
rompath              C:\attract\EMU\AMIGA CD32\roms\
romext               .cue\
system               Amiga CD32\
info_source          thegamesdb.net\
exit_hotkey          Escape

Note : for portable Version, create a configuration folder and set it as base-dir-parameter. Copy CD32-Kickstarts to folder Kickstarts.

* * * * *\
**> ATARI ST / AtariST**

executable           C:\attract\EMU\AmigaST\hatari.exe\
args                 --fullscreen "[romfilename]"\
rompath              C:\attract\EMU\AmigaST\ROMS\
romext               .st\
system               Amiga\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE : to avoid appdata configuration : remove Hatari-folder from appdata > start Hatari > save config File > overwrite hatari.cfg

* * * * *\
**> Atari Lynx**

executable           C:\attract\EMU\Atari Lynx\mednafen.exe\
args                 "[romfilename]"\
rompath              C:\attract\EMU\Atari Lynx\ROMS\
romext               .lnx\
system               Atari Lynx\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE : to set fullscreen: start a game from AM > press ALT + Enter\
after that, fullscreen is saved.

NOTE : to configure Joypad: start a game from AM > press SHIFT + ALT + 1 > follow messages to set buttons

* * * * *\
**> C64 / Commodore c64**

executable           C:\attract\EMU\C64\x64.exe\
args                 -autostart "[romfilename]" -fullscreen -autostart-warp\
rompath              C:\attract\EMU\C64\ROMS\
romext               .d64;.t64\
system               Commodore 64\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> DosBOX**

executable           CMD\
args                 /c "[romfilename]"\
rompath              C:\attract\EMU\DosBox\ROMS\
romext               .bat\
system               PC\
info_source          thegamesdb.net

NOTE:\
-Install dosbox\
-Create a batch-file dosbox_generator.bat with this source-code (modify your paths to a 'main-link-folder' and DOSBox.exe:

Code: [Select]

```
@echo offSET linkspath=C:\attract\EMU\DosBox\ROMS\SET dosboxpath=C:\attract\EMU\DosBox\DOSBox.exefor %%a in ("%1") do (set filepath=%%~dpa)cd %filepath%for %%* in (.) do (set currentfolder=%%~nx*echo %%~nx*)echo "%dosboxpath%" > "%linkspath%%currentfolder%.bat" %1 -exit -fullscreen
```\
-Rename your game-folders to correct game-names (e.g. Wolfenstein3D)\
-Just drag&drop wolf3d.exe on dosbox-generator.bat\
-it creates a Wolfenstein3D.bat (with correct DOSBox-settings)\
![](http://fs5.directupload.net/images/160308/8ktobdic.png)\
![](http://fs5.directupload.net/images/170516/9uwlhzkt.png)

* * * * *\
**> FBA / Final Burn Alpha / FinalBurn Alpha / FinalBurnAlpha**

executable           C:\attract\EMU\FBA\fba64.exe\
args                 "[name]"\
rompath              C:\attract\EMU\FBA\ROMS\
romext               .zip\
system               Arcade\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> Flash**

-download the portable version of flash player [here](http://fpdownload.macromedia.com/pub/labs/flashruntimes/flashplayer/flashplayer_32_sa_debug.exe)\
-create and compile an autoit script with this code (something like flashstarter.au3)

Code: [Select]

```
#include <Misc.au3>run(@ScriptDir & "\flashplayer_32_sa_debug.exe" & " " & $CmdLine[1])WinWaitActive("Adobe Flash Player 32", "")WinWait("Adobe Flash Player 32", "")Send("^f")While 1If _IsPressed ("1B") ThenProcessClose("flashplayer_32_sa_debug.exe")ExitEndIfWEnd
```

-copy compiled exe to same folder of flashplayer_32_sa_debug.exe

executable           C:\attract\EMU\flash\flashstarter..exe\
args                 "[romfilename]"\
rompath              C:\attract\EMU\flash\ROMS\
romext               .swf\
system               Arcade\
info_source          thegamesdb.net\
nb_mode_wait         3\
exit_hotkey          Escape

it starts swf-file directly and exists with ESC button

* * * * *\
**> Future Pinball**

Note : to enable fullscreen : start Future Pinball > Preferences > Video/Rendering Options > choose Fullscreen > OK

executable           C:\attract\EMU\Future Pinball\Future Pinball.exe\
args                 /open "[romfilename]" /play /exit\
rompath              C:\attract\EMU\Future Pinball\Tables\
romext               .fpt\
system               Arcade\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> GB / Gameboy / Nintendo Game Boy**

executable           C:\attract\EMU\Gameboy\VisualBoyAdvance.exe\
args                 "[romfilename]" --fullscreen\
rompath              C:\attract\EMU\Gameboy\Roms\
romext               .gb\
system               Nintendo Game Boy\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> Gamecube / Game Cube / Nintendo Gamecube**

executable           C:\attract\EMU\Gamecube\Dolphin.exe\
args                 -e "[romfilename]"  --config "Dolphin.Display.Fullscreen=True"\
rompath              C:\attract\EMU\Gamecube\ROMS\
romext               .iso;.gcm\
system               Nintendo GameCube\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE: Dolphin creates a configuration folder in your documents-folder.\
But this can be undesirable if you use Dolphin with other systems (Wii, Gamecube, WAD).\
Just create a textfile called portable.txt in same folder, where Dolphin.exe is found.

* * * * *\
**> GBA / GameBoyAdvanced / Gameboy Advanced / Nintendo Game Boy Advanced**

executable           C:\attract\EMU\GBA\VisualBoyAdvance.exe\
args                 "[romfilename]" --Fullscreen\
rompath              C:\attract\EMU\GBA\Roms\
romext               .gba;.bin\
system               Nintendo Game Boy Advance\
info_source          thegamesdb.net\
nb_mode_wait         5\
exit_hotkey          Escape

* * * * *\
**> Jaguar / ATARI Jaguar**

executable           C:\attract\EMU\Jaguar\virtualjaguar.exe\
args                 -d -g -b -f "[romfilename]"\
rompath              C:\attract\EMU\Jaguar\ROMS\
romext               .jag;.j64\
system               Atari Jaguar\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE : after first start of virtualjaguar, set path to ROM-folder (Jaguar > Configure > General)

* * * * *\
**> LCD Handheld**

executable           C:\attract\EMU\LCD Handheld\mame.exe\
args                 [name] -skip_gameinfo\
rompath              C:\attract\EMU\LCD Handheld\roms\
romext               .zip;.7z;<DIR>\
system               Arcade\
info_source          listxml\
exit_hotkey          Escape

* * * * *\
**> MAME**

executable           C:\attract\EMU\mame\mame.exe\
args                 [name] -skip_gameinfo\
rompath              C:\attract\EMU\mame\roms\
romext               .zip;.7z;<DIR>\
system               Arcade\
info_source          listxml\
exit_hotkey          Escape

NOTE: [Standard-Mame shows nag screens](http://forum.attractmode.org/index.php?PHPSESSID=708c1c5b6fb4cc4d4b4bf571ab6fdd94&topic=348.0)

* * * * *\
**> Megadrive / SEGA Mega Drive / Sega Genesis / GEN / MD**

executable           C:\attract\EMU\megadrive\Fusion.exe\
args                 "[romfilename]" -gen -auto -fullscreen\
rompath              C:\attract\EMU\megadrive\ROMS\
romext               .sms;.sg;.sc;.mv;.gg;.cue;.bin;.zip\
system               Sega Genesis\
info_source          thegamesdb.net\
nb_mode_wait         5\
exit_hotkey          Escape

NOTE : Under Windows 10, Fusion.exe do not show fullscreen. to fix it:\
right mouse button on Fusion.exe > Properties > Compatibility > Set 'Windows XP SP3'

* * * * *\
**> MSU1 via bsnes / MSU-1 / Media Streaming Unit 1 with BSNES**

use BSNES v1.15 [from here](https://github.com/bsnes-emu/bsnes/releases/tag/v115).\
set DirectInput in BSNES settings before\
start bsnes.exe > Settings > Input > Drivers > Input : Driver : Windows

create a autoit-script and set it in AM (for example : START.au3):

Code: [Select]

```
; set DirectInput in BSNES settings before:; start bsnes.exe > Settings > Input > Drivers > Input : Driver : Windows#include <Misc.au3>;;;;;;;;;;;;;;;;;;;;;   PATHS   ;;;;;;;;;;;;;;;;;;;$EXECUTABLE = "C:\attract\EMU\MSU1\bsnes.exe"$ROMPATH = "C:\attract\EMU\MSU1\ROMS\";;;;;;;;;;;;;;;;;;;;;   PATHS   ;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;   STARTING  BSNES   ;;;;;;;;;;;;;;;;;;;;run ('"' & $EXECUTABLE & '"' & " --fullscreen " & '"' & $ROMPATH & $CmdLine[1] & "\" & $CmdLine[1] & ".sfc");;;;;;;;;;;;;;;;;;;;;   STARTING  BSNES   ;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;   Remove Mouse Cursor from FOCUS   ;;;;;;;;;;;;;;;;;;;;MouseMove(2000, 308, 0);;;;;;;;;;;;;;;;;;;;;   Remove Mouse Cursor from FOCUS   ;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;   wait for ESC    ;;;;;;;;;;;;;;;;;;;;;;While 1If _IsPressed ("1B") ThenProcessClose("bsnes.exe")ExitEndIfWEnd;;;;;;;;;;;;;;;;;;;;;   wait for ESC    ;;;;;;;;;;;;;;;;;;;;;;
```\
executable           C:\attract\EMU\MSU1\START.exe\
args                 "[name]"\
rompath              C:\attract\EMU\MSU1\ROMS\
romext               <DIR>\
system               Super Nintendo (SNES)\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE : to avoid appdata configuration : create bsnes-qt.cfg, where bsnes.exe is found. copy all files from appdata to bsnes.exe folder too

* * * * *\
**> NES / Nintendo Entertainment System**

executable           C:\attract\EMU\NES\Mesen.exe\
args                 "[romfilename]" /fullscreen /DoNotSaveSettings\
rompath              C:\attract\EMU\NES\ROMS\
romext               .nes\
system               Nintendo Entertainment System (NES)\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> OpenBOR**

executable           cmd\
args                 /c cd C:\attract\EMU\OpenBOR\[name] & start OpenBOR.exe & start C:\attract\EMU\OpenBOR\wait_for_ESC.exe\
rompath              C:\attract\EMU\OpenBOR\
romext               <DIR>\
system               Arcade\
info_source          thegamesdb.net\
nb_mode_wait         3\
exit_hotkey          Escape

NOTE: ESC-Key of AM doesn't work. So you need an external program like an autoit-script. Create wait_for_ESC.au3 and compile this sourcecode to .exe:

Code: [Select]

```
#include <Misc.au3>While 1If _IsPressed ("1B") ThenProcessClose("OpenBOR.exe");MsgBox(0, '', "Button pushed")ExitEndIfWEnd
```\
-Copy it to C:\attract\EMU\OpenBOR\
![](http://fs1.directupload.net/images/180302/z8fzbacc.gif)

-Rename openbor-folders to correct game-names ( C:\attract\EMU\OpenBOR\Night Slasher X )\
![](http://fs5.directupload.net/images/160308/cjwswqkb.png)

* * * * *\
**> scumm-vm / ScummVM**

executable           C:\attract\EMU\ScummVM\scummvm.exe\
args                 --config="C:\attract\EMU\ScummVM\Myscummvm.ini" -f [name]\
rompath              C:\attract\EMU\ScummVM\ROMS\
romext               <DIR>\
system               PC\
info_source          scummvm\
exit_hotkey          Escape

NOTE: to get correct game names : start scummvm.exe > add your games manually > exit scummvm > start AM > create Collection/Romlist > scrape Artwork

NOTE : to avoid appdata configuration : scummvm.exe --config=Myscummvm.ini

* * * * *\
**> Sega 32x**

executable           C:\attract\EMU\Sega 32x\Fusion.exe\
args                 "[romfilename]" -32x -auto -fullscreen\
rompath              C:\attract\EMU\Sega 32x\ROMS\
romext               .32x\
system               Sega 32X\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> Sega Dreamcast with demul**

create a autoit-script and set it in AM (for example : START.au3) to start games in fullscreen:

Code: [Select]

```
#include <Misc.au3>ShellExecute(@ScriptDir & "\demul.exe", ' -run=dc -image="' & $CmdLine[1] & '"')sleep(2000)Send("!{ENTER}")While 1If _IsPressed ("1B") ThenProcessClose("demul.exe");MsgBox(0, '', "Button pushed")ExitEndIfWEnd
```\
executable           C:\attract\EMU\Sega Dreamcast\START.exe\
args                 "[romfilename]"\
rompath              C:\attract\EMU\Sega Dreamcast\ROMS\
romext               .cdi\
system               Sega Dreamcast\
info_source          thegamesdb.net\
nb_mode_wait         5\
exit_hotkey          Escape

* * * * *\
**> Sega Saturn**

executable           C:\attract\EMU\Sega Saturn\EmuHawk.exe\
args                 "[romfilename]" --fullscreen\
rompath              C:\attract\EMU\Sega Saturn\ROMS\
romext               .cue\
system               Sega Saturn\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> SNES / Super Nintendo Entertainment System / Snes9x**

executable           C:\attract\EMU\SNES\snes9x-x64.exe\
args                 "[romfilename]" -fullscreen\
rompath              C:\attract\EMU\SNES\ROMS\
romext               .smc\
system               Super Nintendo (SNES)\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> Sony PS2 / Sony Playstation2 / Sony Playstation 2**

executable           C:\attract\EMU\Sony PS2\pcsx2.exe\
args                 "[romfilename]" --fullscreen --nogui\
rompath              C:\attract\EMU\Sony PS2\ROMS\
romext               .iso;.bin;.mdf;.img\
system               Sony Playstation 2\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> Sony PS1 / Sony PSX / Sony Playstation 1 / Sony Playstation1**

executable           C:\attract\EMU\Sony PSX\ePSXe.exe\
args                  -fullscreen -nogui -loadbin "[romfilename]"\
rompath              C:\attract\EMU\Sony PSX\ROMS\
romext               .cue;.iso\
system               Sony Playstation\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> Steam**

executable           C:\attract\EMU\Steam\Steam.exe\
args                 -applaunch [name]\
rompath              C:\attract\EMU\Steam\SteamApps\
romext               .acf\
system               PC\
info_source          steam

* * * * *\
**> Visual Pinball**

executable           C:\attract\EMU\Visual Pinball\VPinballX.exe\
args                  /play "[romfilename]"\
rompath              C:\attract\EMU\Visual Pinball\Tables\
romext               .vpt;.vpx\
system               Arcade\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> VLC-Movies / Videos via VLC**

executable           C:\Program Files\VideoLAN\VLC\vlc.exe\
args                 "[romfilename]" --fullscreen\
rompath              C:\attract\EMU\media\MOVIES\
romext               .avi;.mpg;.mpeg;.mov;.mkv;.mp4\
info_source          thegamesdb.net\
import_extras        Arcade\
exit_hotkey          Escape

modify this parameters in c:\documents and settings\your_username\application data\vlc\vlcrc\
(on Win7 : C:\Users\your_username\AppData\Roaming\vlc )

#3331     video-title-show=0\
#3430     osd=0\
#3322     video-on-top=1\
![](http://fs5.directupload.net/images/160308/b7tox2vs.png)

* * * * *\
**> VLC-mp3 / Music via VLC**

executable           C:\Program Files\VideoLAN\VLC\vlc.exe\
args                 "[romfilename]" --fullscreen\
rompath              C:\attract\media\MUSIC\
romext               .mp3;.wav;.m3u;.ogg;.snd;.wma\
info_source          thegamesdb.net\
import_extras        Arcade\
exit_hotkey          Escape

create a 'main-media-folder' for all media-files

* * * * *\
**> Wii / Nintendo Wii**

executable           C:\attract\EMU\Wii\Dolphin.exe\
args                 -e "[romfilename]"  --config "Dolphin.Display.Fullscreen=True"\
rompath              C:\attract\EMU\Wii\ROMS\
romext               .iso;.wbfs\
system               Nintendo Wii\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE: Dolphin creates a configuration folder in your documents-folder.\
But this can be undesirable if you use Dolphin with other systems (Wii, Gamecube, WAD).\
Just create a textfile called portable.txt in same folder, where Dolphin.exe is found.

* * * * *\
**> windows_games / Windows Games**

executable           cmd\
args                 /c "[romfilename]"\
rompath              C:\attract\EMU\windows_games/roms\
romext               .lnk;.bat

create a 'main-folder' for all games/roms; create to this folder shortcuts/link-files (.lnk) of your exe-files\
![](http://fs5.directupload.net/images/160308/9n8jx3ca.png)

* * * * *\
**> WinKawaks for special "Winkawaks-Roms" CPS1 / CPS2 / NeoGeo / CPS-1 / CPS-2 / Neo Geo**

executable           "WinKawaks.exe"\
args                 [name] -fullscreen\
workdir              C:\attract\EMU\WinKawaks\
rompath              C:\attract\EMU\WinKawaks\roms\
romext               .zip\
system               Arcade\
info_source          thegamesdb.net\
exit_hotkey          Escape

Note : to get artwork :\
create a second mame installation > rename it to WinKawaks > copy your rom files to rom-folder > start AM > create romlist > scrape artwork > close AM > remove second mame installation or replace everything with WinKawaks installation files

executable           C:\attract\EMU\WinKawaks\mame.exe\
args                 [name] -skip_gameinfo\
rompath              C:\attract\EMU\WinKawaks\roms\
romext               .zip;.7z;<DIR>\
system               Arcade\
info_source          listxml\
exit_hotkey          Escape\
artwork    marquee         C:\attract\scraper\WinKawaks\marquee\
artwork    snap            C:\attract\scraper\WinKawaks\video;C:\attract\scraper\WinKawaks\flyer

* * * * *\
**> ZSNES / SNES / Super Nintendo Entertainment System**

executable           C:\attract\EMU\zsnes\zsnesw.exe\
args                 -m "[romfilename]"\
rompath              C:\attract\EMU\zsnes\ROMS\
romext               .smc\
system               Super Nintendo (SNES)\
info_source          thegamesdb.net\
exit_hotkey          Escape

Note : in znes > config > video > choose your resolution of choice with DS and F (allow Filters, Stretch and Fullscreen)\
![](http://fs5.directupload.net/images/160308/zs3ynm98.png)

* * * * *\
**> ZX Spectrum / Sinclair ZX Spectrum**

executable           C:\attract\EMU\ZX Spectrum\fuse.exe\
args                 --full-screen "[romfilename]" --disk-try-merge always\
rompath              C:\attract\EMU\ZX Spectrum\ROMS\
romext               .dsk;.tap\
system               Sinclair ZX Spectrum\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE : to get fullscreen parameter, you need the fuse-1.5.1-sdl.zip. [Here](https://drive.google.com/drive/folders/0B_2W9q0zVYtdWjBKSEpxWFMwNFE)

* * * * *\
**> 3DO / 3DO Interactive Multiplayer / Panasonic 3DO**

executable           C:\attract\EMU\3DO\4DO.exe\
args                 --StartFullScreen -StartLoadFile "[romfilename]"\
rompath              C:\attract\EMU\3DO\ROMS\
romext               .iso\
system               3DO\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> 3DS / Nintendo 3DS**

executable           C:\attract\EMU\3DS\citra-qt.exe\
args                 "[romfilename]"\
rompath              C:\attract\EMU\3DS\ROMS\
romext               .3ds;.3dsx\
system               Nintendo 3DS\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE: to create Fullscreen:\
create config-file C:\attract\EMU\3DS\user\config\qt-config.ini\
fullscreen=true

* * * * *\
**> Atari 2600**

executable           C:\attract\EMU\Atari 2600\EmuHawk.exe\
args                 "[romfilename]" --fullscreen\
rompath              C:\attract\EMU\Atari 2600\ROMS\
romext               .a26\
system               Atari 2600\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> Atari 5200**

executable           "kat5200.exe"\
args                 "[romfilename]"\
workdir              C:\attract\EMU\Atari 5200\
rompath              C:\attract\EMU\Atari 5200\ROMS\
romext               .a52\
system               Atari 5200\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE : to get emulator portable:\
edit 'C:\attract\EMU\Atari 5200\portable.txt' from 0 to 1

NOTE : to set fullscreen:\
set option in emulator settings

* * * * *\
**> CPS1 / Capcom Play System 1 / CPS-1**

executable           "nebula.exe"\
args                 [name]\
workdir              C:\attract\EMU\CPS1\
rompath              C:\attract\EMU\CPS1\roms\
romext               .zip\
system               Arcade\
info_source          listxml\
exit_hotkey          Escape

NOTE: to create Fullscreen:\
start C:\attract\EMU\CPS1\nebulaconfig.exe\
There set Fullscreen Option

* * * * *\
**> CPS2 / Capcom Play System 2 / CPS-2**

executable           "nebula.exe"\
args                 [name]\
workdir              C:\attract\EMU\CPS2\
rompath              C:\attract\EMU\CPS2\roms\
romext               .zip\
system               Arcade\
info_source          listxml\
exit_hotkey          Escape

NOTE: to create Fullscreen:\
start C:\attract\EMU\CPS2\nebulaconfig.exe\
There set Fullscreen Option

* * * * *\
**> Game Gear / SEGA GameGear / GG**

executable           C:\attract\EMU\GameGear\Fusion.exe\
args                 "[romfilename]" -gg -auto -fullscreen\
rompath              C:\attract\EMU\GameGear\ROMS\
romext               .sms;.sg;.sc;.mv;.gg;.cue;.bin;.zip\
system               Sega Game Gear\
info_source          thegamesdb.net\
nb_mode_wait         5\
exit_hotkey          Escape

NOTE : Under Windows 10, Fusion.exe do not show fullscreen. to fix it:\
right mouse button on Fusion.exe > Properties > Compatibility > Set 'Windows XP SP3'

* * * * *\
**> Master System / SEGA MasterSystem / SMS**

executable           C:\attract\EMU\Sega Master System\Fusion.exe\
args                 "[romfilename]" -sms -auto -fullscreen\
rompath              C:\attract\EMU\Sega Master System\ROMS\
romext               .sms;.sg;.sc;.mv;.gg;.cue;.bin;.zip\
system               Sega Master System\
info_source          thegamesdb.net\
nb_mode_wait         5\
exit_hotkey          Escape

NOTE : Under Windows 10, Fusion.exe do not show fullscreen. to fix it:\
right mouse button on Fusion.exe > Properties > Compatibility > Set 'Windows XP SP3'

* * * * *\
**> Mega CD / SEGA MegaCD / SEGA CD / SCD**

executable           C:\attract\EMU\Sega Mega CD\Fusion.exe\
args                 "[romfilename]" -scd -fullscreen\
rompath              C:\attract\EMU\Sega Mega CD\ROMS\
romext               .cue\
system               Sega CD\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE : Under Windows 10, Fusion.exe do not show fullscreen. to fix it:\
right mouse button on Fusion.exe > Properties > Compatibility > Set 'Windows XP SP3'

NOTE : BIOS Files are necessary :\
us_scd1_9210.bin\
jp_mcd1_9112.bin\
eu_mcd1_9210.bin

NOTE : if game stucks, freezes or you get a black screen:\
start Fusion.exe > Options > set 'Perfect Sync'

* * * * *\
**> NDS via DeSmuME / Nintendo DS with DeSmuME**

Note : Using DeSmuME, it opens a nag screen after loading a romfile.\
use this autoit script (START.au3) to remove nag screen

executable           C:\attract\EMU\NDS\START.exe\
args                 "[romfilename]"\
rompath              C:\attract\EMU\NDS\ROMS\
romext               .nds\
system               Nintendo DS\
info_source          thegamesdb.net\
exit_hotkey          Escape

Code: [Select]

```
#include <Misc.au3>;get/overgive ROM from CMDShellExecute(@ScriptDir & "\DeSmuME_0.9.11_x64.exe", ' ' & $CmdLine[1] & '"'); Message : BUGWinWaitActive("DeSmuME 0.9.11 x64", "due to a bug")WinWait("DeSmuME 0.9.11 x64", "due to a bug")ControlClick("DeSmuME 0.9.11 x64", "due to a bug", "[CLASS:Button; INSTANCE:1]"); Alt + Enter for Fullscreensleep(100)WinWaitActive("DeSmuME 0.9.11 x64", "")WinWait("DeSmuME 0.9.11 x64", "")Send("!{Enter}"); wait for ESC and EXIT emulatorWhile 1If _IsPressed ("1B") ThenProcessClose("DeSmuME_0.9.11_x64.exe");MsgBox(0, '', "Button pushed")ExitEndIfWEnd
```

* * * * *\
**> Neo Geo / NeoGeo MVS / SNK Multi Video System**

executable           C:\attract\EMU\NeoGeo\mame.exe\
args                 [name] -skip_gameinfo\
rompath              C:\attract\EMU\NeoGeo\roms\
romext               .zip;.7z;<DIR>\
system               Arcade\
info_source          listxml\
exit_hotkey          Escape

* * * * *\
**> NES FDS / Nintendo Entertainment System - Famicom Disk System**

executable           C:\attract\EMU\NES Famicom Disk System\Mesen.exe\
args                 "[romfilename]" /fullscreen /DoNotSaveSettings\
rompath              C:\attract\EMU\NES Famicom Disk System\ROMS\
romext               .fds\
system               Famicom Disk System\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> PC Engine / TurboGrafx16 / NEC Turbografx 16 / Turbografix 16**

executable           C:\attract\EMU\PC Engine - Turbografx16\EmuHawk.exe\
args                 "[romfilename]" --fullscreen\
rompath              C:\attract\EMU\PC Engine - Turbografx16\ROMS\
romext               .pce\
system               TurboGrafx 16\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> SuFami Turbo via ZSNES / Nintendo Super Famicom Turbo with ZSNES**

executable           C:\attract\EMU\SuFami Turbo\zsnesw.exe\
args                 -m "[romfilename]"\
rompath              C:\attract\EMU\SuFami Turbo\ROMS\
romext               .st\
system               Super Nintendo (SNES)\
info_source          thegamesdb.net\
exit_hotkey          Escape

NOTE : you need stbios.bin (filesize : 256 kb) or downoad Sufami BIOS.smc (same size; rename the file to stbios.bin). Set path to this file in ZSNES.\
start Zsnes > Config > Paths > Sufami Turbo : Path_to_file\stbios.bin

NOTE : with ZSNES and Snex9X, you only could import one cartridge.\
So you can't share data between two games/cartridges.

* * * * *\
**> SuFami Turbo via BSNES / Nintendo Super Famicom Turbo with BSNES**

NOTE : with BSNES, you can use Sufami Turbo crossplay / share data between two games/cartridges.\
[use version v1.15](https://github.com/bsnes-emu/bsnes/releases/tag/v115)

NOTE : use this autoit script (START.au3), to import two games in AM:

executable           C:\attract\EMU\SuFami Turbo\START.exe\
args                 "[romfilename]"\
rompath              C:\attract\EMU\SuFami Turbo\ROMS\
romext               .st\
system               Super Nintendo (SNES)\
info_source          thegamesdb.net\
exit_hotkey          Escape

Code: [Select]

```
#include <MsgBoxConstants.au3>#include <Misc.au3>$EXECUTABLE = "C:\attract\EMU\SuFami Turbo\bsnes.exe"$ROMPATH = "C:\attract\EMU\SuFami Turbo\ROMS\"$BIOSPATH = "C:\attract\EMU\SuFami Turbo\BIOS\bios.rom"; read FIRST GAME and set .whatever behindLocal $hSearch = FileFindFirstFile($ROMPATH & "*.whatever")Local $sFileName = "", $iResult = 0While 1$sFileName = FileFindNextFile($hSearch)If @error Then; if no .whatever file exists, then create FIRST GAME with .whateverFileWrite($CmdLine[1]&".whatever",$CmdLine[1]&".whatever")ExitExitLoopEndIfIf $iResult <> $IDOK Then ExitLoopWEndFileClose($hSearch); if FIRST GAME with .whatever exists, then start BSNES with FIRST GAME and SECOND GAME; bsnes.exe + path to bios.rom + read txt from FIRST GAME (cut .whatever) + get SECOND GAME from cmdlinerun('"' & $EXECUTABLE & '"' & " --fullscreen -st " & '"'& $BIOSPATH & '"' & " " & '"' & StringTrimRight($ROMPATH & $sFileName,9) & '"' & " " & '"' & $CmdLine[1] & '"'); move Mouse from centerMouseMove(2000, 308, 0)FileDelete($ROMPATH & $sFileName); wait for ESC, then exit BSNESWhile 1If _IsPressed ("1B") ThenProcessClose("bsnes.exe")ExitEndIfWEnd
```

* * * * *\
**> Super Gameboy 1 via BSNES / Nintendo Super Game Boy 1 with BSNES**

NOTE : with BSNES, you can load Gameboy Games with Super Gameboy 1 Romfile.\
[use version v1.15](https://github.com/bsnes-emu/bsnes/releases/tag/v115)

NOTE : use this autoit script (START.au3), to import GameBoy games in AM:

executable           C:\attract\EMU\Super Gameboy 1\START.exe\
args                 "[romfilename]"\
rompath              C:\attract\EMU\Super Gameboy 1\ROMS\
romext               .gb\
system               Nintendo Game Boy\
info_source          thegamesdb.net\
exit_hotkey          Escape

Code: [Select]

```
; set DirectInput in BSNES settings before:; start bsnes.exe > Settings > Input > Drivers > Input : Driver : Windows#include <Misc.au3>;;;;;;;;;;;;;;;;;;;;;   PATHS   ;;;;;;;;;;;;;;;;;;;$EXECUTABLE = "C:\attract\EMU\Super Gameboy 1\bsnes.exe"$BIOSPATH = "C:\attract\EMU\Super Gameboy 1\BIOS\sgb1.rom";;;;;;;;;;;;;;;;;;;;;   PATHS   ;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;   STARTING  BSNES   ;;;;;;;;;;;;;;;;;;;;run ('"' & $EXECUTABLE & '"' & " --fullscreen " & '"' & $BIOSPATH & '"' & ' "' & $CmdLine[1] & '"');;;;;;;;;;;;;;;;;;;;;   STARTING  BSNES   ;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;   Remove Mouse Cursor from FOCUS   ;;;;;;;;;;;;;;;;;;;;MouseMove(2000, 308, 0);;;;;;;;;;;;;;;;;;;;;   Remove Mouse Cursor from FOCUS   ;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;   wait for ESC    ;;;;;;;;;;;;;;;;;;;;;;While 1If _IsPressed ("1B") ThenProcessClose("bsnes.exe")ExitEndIfWEnd;;;;;;;;;;;;;;;;;;;;;   wait for ESC    ;;;;;;;;;;;;;;;;;;;;;;
```

* * * * *\
**> Super Gameboy 2 via BSNES / Nintendo Super Game Boy 2 with BSNES**

NOTE : with BSNES, you can load Gameboy Games with Super Gameboy 2 Romfile.\
[use version v1.15](https://github.com/bsnes-emu/bsnes/releases/tag/v115)

NOTE : use this autoit script (START.au3), to import GameBoy games in AM:

executable           C:\attract\EMU\Super Gameboy 2\START.exe\
args                 "[romfilename]"\
rompath              C:\attract\EMU\Super Gameboy 2\ROMS\
romext               .gb\
system               Nintendo Game Boy\
info_source          thegamesdb.net\
exit_hotkey          Escape

Code: [Select]

```
; set DirectInput in BSNES settings before:; start bsnes.exe > Settings > Input > Drivers > Input : Driver : Windows#include <Misc.au3>;;;;;;;;;;;;;;;;;;;;;   PATHS   ;;;;;;;;;;;;;;;;;;;$EXECUTABLE = "C:\attract\EMU\Super Gameboy 2\bsnes.exe"$BIOSPATH = "C:\attract\EMU\Super Gameboy 2\BIOS\sgb2.rom";;;;;;;;;;;;;;;;;;;;;   PATHS   ;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;   STARTING  BSNES   ;;;;;;;;;;;;;;;;;;;;run ('"' & $EXECUTABLE & '"' & " --fullscreen " & '"' & $BIOSPATH & '"' & ' "' & $CmdLine[1] & '"');;;;;;;;;;;;;;;;;;;;;   STARTING  BSNES   ;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;   Remove Mouse Cursor from FOCUS   ;;;;;;;;;;;;;;;;;;;;MouseMove(2000, 308, 0);;;;;;;;;;;;;;;;;;;;;   Remove Mouse Cursor from FOCUS   ;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;   wait for ESC    ;;;;;;;;;;;;;;;;;;;;;;While 1If _IsPressed ("1B") ThenProcessClose("bsnes.exe")ExitEndIfWEnd;;;;;;;;;;;;;;;;;;;;;   wait for ESC    ;;;;;;;;;;;;;;;;;;;;;;
```

* * * * *\
**> Wonderswan / Bandai Wonder Swan**

executable           C:\attract\EMU\Wonderswan\EmuHawk.exe\
args                 "[romfilename]" --fullscreen\
rompath              C:\attract\EMU\Wonderswan\ROMS\
romext               .ws\
system               WonderSwan\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> Wonderswan Color / Bandai Wonder Swan Color**

executable           C:\attract\EMU\Wonderswan Color\EmuHawk.exe\
args                 "[romfilename]" --fullscreen\
rompath              C:\attract\EMU\Wonderswan Color\ROMS\
romext               .wsc\
system               Wonderswan Color\
info_source          thegamesdb.net\
exit_hotkey          Escape


* * * * *\
**> Daphne / Laserdisc / LD**

keep always the same folder and file names (here : lair and badlands)

-extract games to rom folder:\
C:\attract\EMU\Daphne\roms\lair     =>     *C:\attract\EMU\Daphne\roms\lair\dl_f2_u1.bin and so on*

C:\attract\EMU\Daphne\roms\badlands     =>     *C:\attract\EMU\Daphne\roms\badlands\badlands.a13 and so on*

-extract media files (video and sound) to a folder:\
C:\attract\EMU\Daphne\mpeg2\lair     =>     *C:\attract\EMU\Daphne\mpeg2\lair\lair.m2v and so on*

C:\attract\EMU\Daphne\mpeg2\badlands     =>     *C:\attract\EMU\Daphne\mpeg2\badlands\badlands-pc.m2v and so on*

-create a textfile each game, that contains the path and filename to media files:\
C:\attract\EMU\Daphne\framefile\lair.txt\
*it contains:*\
C:\attract\EMU\Daphne\mpeg2\lair\\
151   lair.m2v

C:\attract\EMU\Daphne\framefile\badlands.txt\
*it contains:*\
C:\attract\EMU\Daphne\mpeg2\badlands\\
151 badlands-pc.m2v

-create .bat files each game:\
C:\attract\EMU\Daphne\BAT\Dragons Lair.bat\
*it contains:*\
C:\attract\EMU\Daphne\Daphne.exe lair vldp -fullscreen -x 640 -y 480 -nohwaccel -framefile C:\attract\EMU\Daphne\framefile\lair.txt

C:\attract\EMU\Daphne\BAT\Badlands.bat\
*it contains:*\
C:\attract\EMU\Daphne\daphne.exe badlands vldp -framefile C:\attract\EMU\Daphne\framefile\badlands.txt -fullscreen

executable           CMD\
args                 /c "[romfilename]"\
rompath              C:\attract\EMU\Daphne\BAT\
romext               .bat\
system               Pioneer LaserActive\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> Fruit Machine / FruitMachine / Slot Games**

Coming soon\
MFME / Multi Fruit Machine Emulator

* * * * *\
**> N64 / Nintendo 64**

executable           C:\attract\EMU\N64\Project64.exe\
args                 "[romfilename]"\
rompath              C:\attract\EMU\N64\ROMS\
romext               .n64;.z64;.zip\
system               Nintendo 64\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *\
**> XBOX / XBOX-Classic / XBOX1 / Microsoft X-Box**

NOTE : use Cxbx-Reloaded

NOTE : make a folder, each game

NOTE : set Fullscreen-Option in cxbx-options (Settings > Config Video > Use Exclusive Video Mode)

executable           C:\attract\EMU\Xbox\cxbx.exe\
args                 /load "[romfilename]/default.xbe"\
rompath              C:\attract\EMU\Xbox\ROMS\
romext               <DIR>\
system               Microsoft Xbox\
info_source          thegamesdb.net\
exit_hotkey          Escape

* * * * *