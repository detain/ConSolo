Clipped from: [http://forum.attractmode.org/index.php?topic=503.0](http://forum.attractmode.org/index.php?topic=503.0) 

   
   
**\> AMIGA 500**   
   
**executable           C:\\attract\\EMU\\amiga\\System\\FS-UAE\\Windows\\x86-64\\fs-uae.exe**   
**args                 --floppy-drive-0="\[romfilename\]" --fullscreen --floppy-drive-0-sounds=0 --floppy-drive-speed=100 --floppy-drive-volume-empty=100  --base-dir="C:\\attract\\EMU\\amiga\\Configuration"**   
**rompath              C:\\attract\\EMU\\amiga\\roms**   
**romext               .adf**   
**system               Amiga**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
**Note : for portable Version, create a configuration folder and set it as base-dir-parameter**   
   
   
**\> AMIGA CD32**   
   
**executable           C:\\attract\\EMU\\AMIGA CD32\\System\\FS-UAE\\Windows\\x86-64\\fs-uae.exe**   
**args                 --amiga-model=CD32 --fast-memory=8192 --cdrom-drive-0="\[romfilename\]" --fullscreen --base-dir="C:\\attract\\EMU\\Amiga CD32\\Configuration"**   
**rompath              C:\\attract\\EMU\\AMIGA CD32\\roms**   
**romext               .cue**   
**system               Amiga CD32**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
**Note : for portable Version, create a configuration folder and set it as base-dir-parameter. Copy CD32-Kickstarts to folder Kickstarts.**   
   
   
**\> ATARI ST / AtariST**   
   
**executable           C:\\attract\\EMU\\AmigaST\\hatari.exe**   
**args                 --fullscreen "\[romfilename\]"**   
**rompath              C:\\attract\\EMU\\AmigaST\\ROMS**   
**romext               .st**   
**system               Amiga**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
**NOTE : to avoid appdata configuration : remove Hatari-folder from appdata > start Hatari > save config File > overwrite hatari.cfg**   
   
   
**\> Atari Lynx**   
   
**executable           C:\\attract\\EMU\\Atari Lynx\\mednafen.exe**   
**args                 "\[romfilename\]"**   
**rompath              C:\\attract\\EMU\\Atari Lynx\\ROMS**   
**romext               .lnx**   
**system               Atari Lynx**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
**NOTE : to set fullscreen: start a game from AM > press ALT + Enter**   
**after that, fullscreen is saved.**   
   
**NOTE : to configure Joypad: start a game from AM > press SHIFT + ALT + 1 > follow messages to set buttons**   
   
   
**\> C64 / Commodore c64**   
   
**executable           C:\\attract\\EMU\\C64\\x64.exe**   
**args                 -autostart "\[romfilename\]" -fullscreen -autostart-warp**   
**rompath              C:\\attract\\EMU\\C64\\ROMS**   
**romext               .d64;.t64**   
**system               Commodore 64**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
   
**\> DosBOX**   
   
**executable           cmd**   
**args                 /c "\[romfilename\]"**   
**rompath              C:\\attract\\EMU\\dosbox\\links\\**   
**romext               .bat**   
   
**NOTE:**   
**\-Install dosbox**   
**\-Create a batch-file dosbox\_generator.bat with this source-code (modify your paths to a 'main-link-folder' and DOSBox.exe:**   
 

Code: \[Select\] 

@echo off   
SET linkspath=C:\\attract\\EMU\\dosbox\\links\\   
SET dosboxpath=C:\\attract\\EMU\\dosbox\\DOSBox.exe   
   
for %%a in (%1) do (   
set filepath=%%~dpa   
)   
   
cd %filepath%   
for %%\* in (.) do (   
set currentfolder=%%~nx\*   
echo %%~nx\*   
)   
   
echo "%dosboxpath%" > %linkspath%%currentfolder%.bat %1 -exit -fullscreen   
\-Rename your game-folders to correct game-names (e.g. Wolfenstein3D)   
\-Just drag&drop wolf3d.exe on dosbox-generator.bat   
\-it creates a Wolfenstein3D.bat (with correct DOSBox-settings)   
 

   
 

   
   
   
**\> FBA / Final Burn Alpha / FinalBurn Alpha / FinalBurnAlpha**   
   
**executable           C:\\attract\\EMU\\FBA\\fba64.exe**   
**args                 "\[name\]"**   
**rompath              C:\\attract\\EMU\\FBA\\ROMS**   
**romext               .zip**   
**system               Arcade**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
   
**\> Flash**   
   
**\-download the portable version of flash player** [**here**](http://fpdownload.macromedia.com/pub/labs/flashruntimes/flashplayer/flashplayer_32_sa_debug.exe)   
**\-create and compile an autoit script with this code (something like flashstarter.au3)**   
 

Code: \[Select\] 

#include \<Misc.au3>   
   
run(@ScriptDir & "\\flashplayer\_32\_sa\_debug.exe" & " " & $CmdLine\[1\])   
   
WinWaitActive("Adobe Flash Player 32", "")   
WinWait("Adobe Flash Player 32", "")   
Send("^f")   
   
While 1   
If \_IsPressed ("1B") Then   
ProcessClose("flashplayer\_32\_sa\_debug.exe")   
Exit   
EndIf   
WEnd-copy compiled exe to same folder of flashplayer\_32\_sa\_debug.exe   
   
executable           C:\\attract\\EMU\\flash\\flashstarter..exe   
args                 "\[romfilename\]"   
rompath              C:\\attract\\EMU\\flash\\ROMS   
romext               .swf   
system               Arcade   
info\_source          thegamesdb.net   
nb\_mode\_wait         3   
exit\_hotkey          Escape   
   
it starts swf-file directly and exists with ESC button   
   
   
\> Future Pinball    
   
Note : to enable fullscreen : start Future Pinball > Preferences > Video/Rendering Options > choose Fullscreen > OK   
   
executable           C:\\attract\\EMU\\Future Pinball\\Future Pinball.exe   
args                 /open "\[romfilename\]" /play /exit   
rompath              C:\\attract\\EMU\\Future Pinball\\Tables   
romext               .fpt   
system               Arcade   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
   
\> GBA / Gameboy / Game Boy   
   
executable           C:\\attract\\EMU\\Gameboy\\VisualBoyAdvance.exe   
args                 "\[romfilename\]" --fullscreen   
rompath              C:\\attract\\EMU\\Gameboy\\Roms   
romext               .gb   
system               Nintendo Game Boy   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
   
\> Gamecube / Game Cube / Nintendo Gamecube   
   
executable           C:\\attract\\EMU\\Gamecube\\Dolphin.exe   
args                 -e "\[romfilename\]"  --config "Dolphin.Display.Fullscreen=True"   
rompath              C:\\attract\\EMU\\Gamecube\\ROMS   
romext               .iso;.gcm   
system               Nintendo GameCube   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
NOTE: Dolphin creates a configuration folder in your documents-folder.   
But this can be undesirable if you use Dolphin with other systems (Wii, Gamecube, WAD).   
Just create a textfile called portable.txt in same folder, where Dolphin.exe is found.   
   
   
\> GBA / GameBoyAdvanced / Gameboy Advanced / Game Boy Advanced   
   
executable           C:\\attract\\EMU\\GBA\\VisualBoyAdvance.exe   
args                 "\[romfilename\]" --Fullscreen   
rompath              C:\\attract\\EMU\\GBA\\Roms   
romext               .gba;.bin   
system               Nintendo Game Boy Advance   
info\_source          thegamesdb.net   
nb\_mode\_wait         5   
exit\_hotkey          Escape   
   
   
\> Jaguar / ATARI Jaguar   
   
executable           C:\\attract\\EMU\\Jaguar\\virtualjaguar.exe   
args                 -d -g -b -f "\[romfilename\]"   
rompath              C:\\attract\\EMU\\Jaguar\\ROMS   
romext               .jag;.j64   
system               Atari Jaguar   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
NOTE : after first start of virtualjaguar, set path to ROM-folder (Jaguar > Configure > General)   
   
   
\> LCD Handheld   
   
executable           C:\\attract\\EMU\\LCD Handheld\\mame.exe   
args                 \[name\] -skip\_gameinfo   
rompath              C:\\attract\\EMU\\LCD Handheld\\roms   
romext               .zip;.7z;\<DIR>   
system               Arcade   
info\_source          listxml   
exit\_hotkey          Escape   
   
   
\> MAME   
   
executable           C:\\attract\\EMU\\mame\\mame.exe   
args                 \[name\] -skip\_gameinfo   
rompath              C:\\attract\\EMU\\mame\\roms   
romext               .zip;.7z;\<DIR>   
system               Arcade   
info\_source          listxml   
exit\_hotkey          Escape   
   
NOTE: [Standard-Mame shows nag screens](http://forum.attractmode.org/index.php?topic=348.0)   
 [](http://forum.attractmode.org/index.php?topic=348.0)   
 [](http://forum.attractmode.org/index.php?topic=348.0)   
\> Megadrive / SEGA Mega Drive / Sega Genesis   
   
executable           C:\\attract\\EMU\\megadrive\\Fusion.exe   
args                 "\[romfilename\]" -gen -auto -fullscreen   
rompath              C:\\attract\\EMU\\megadrive\\ROMS   
romext               .sms;.sg;.sc;.mv;.gg;.cue;.bin;.zip   
system               Sega Genesis   
info\_source          thegamesdb.net   
nb\_mode\_wait         5   
exit\_hotkey          Escape   
   
NOTE : Under Windows 10, Fusion.exe do not show fullscreen. to fix it:   
right mouse button on Fusion.exe > Properties > Compatibility > Set 'Windows XP SP3'   
   
   
\> MSU1 / bsnes   
   
use BSNES v1.15 [from here](https://github.com/bsnes-emu/bsnes/releases/tag/v115).   
set DirectInput in BSNES settings before   
start bsnes.exe > Settings > Input > Drivers > Input : Driver : Windows   
   
create a autoit-script and set it in AM (for example : START.au3): 

Code: \[Select\] 

; set DirectInput in BSNES settings before:   
; start bsnes.exe > Settings > Input > Drivers > Input : Driver : Windows   
   
#include \<Misc.au3>   
   
;;;;;;;;;;;;;;;;;;;;;   PATHS   ;;;;;;;;;;;;;;;;;;;   
$EXECUTABLE = "C:\\attract\\EMU\\MSU1\\bsnes.exe"   
$ROMPATH = "C:\\attract\\EMU\\MSU1\\ROMS\\"   
;;;;;;;;;;;;;;;;;;;;;   PATHS   ;;;;;;;;;;;;;;;;;;;   
   
   
;;;;;;;;;;;;;;;;;;;;;   STARTING  BSNES   ;;;;;;;;;;;;;;;;;;;;   
run ('"' & $EXECUTABLE & '"' & " --fullscreen " & '"' & $ROMPATH & $CmdLine\[1\] & "\\" & $CmdLine\[1\] & ".sfc")   
;;;;;;;;;;;;;;;;;;;;;   STARTING  BSNES   ;;;;;;;;;;;;;;;;;;;;   
   
   
;;;;;;;;;;;;;;;;;;;;;   Remove Mouse Cursor from FOCUS   ;;;;;;;;;;;;;;;;;;;;   
MouseMove(2000, 308, 0)   
;;;;;;;;;;;;;;;;;;;;;   Remove Mouse Cursor from FOCUS   ;;;;;;;;;;;;;;;;;;;;   
   
   
;;;;;;;;;;;;;;;;;;;;;   wait for ESC    ;;;;;;;;;;;;;;;;;;;;;;   
While 1   
If \_IsPressed ("1B") Then   
ProcessClose("bsnes.exe")   
Exit   
EndIf   
WEnd   
;;;;;;;;;;;;;;;;;;;;;   wait for ESC    ;;;;;;;;;;;;;;;;;;;;;;   
executable           C:\\attract\\EMU\\MSU1\\START.exe   
args                 "\[name\]"   
rompath              C:\\attract\\EMU\\MSU1\\ROMS   
romext               \<DIR>   
system               Super Nintendo (SNES)   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
NOTE : to avoid appdata configuration : create bsnes-qt.cfg, where bsnes.exe is found. copy all files from appdata to bsnes.exe folder too   
   
   
\> NES / Nintendo Entertainment System   
   
executable           C:\\attract\\EMU\\NES\\Mesen.exe   
args                 "\[romfilename\]" /fullscreen /DoNotSaveSettings   
rompath              C:\\attract\\EMU\\NES\\ROMS   
romext               .nes   
system               Nintendo Entertainment System (NES)   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
   
\> OpenBOR   
   
executable           cmd   
args                 /c cd C:\\attract\\EMU\\OpenBOR\\\[name\] & start OpenBOR.exe & start C:\\attract\\EMU\\OpenBOR\\wait\_for\_ESC.exe   
rompath              C:\\attract\\EMU\\OpenBOR   
romext               \<DIR>   
system               Arcade   
info\_source          thegamesdb.net   
nb\_mode\_wait         3   
exit\_hotkey          Escape   
   
NOTE: ESC-Key of AM doesn't work. So you need an external program like an autoit-script. Create wait\_for\_ESC.au3 and compile this sourcecode to .exe:   
 

Code: \[Select\] 

#include \<Misc.au3>   
   
While 1   
If \_IsPressed ("1B") Then   
ProcessClose("OpenBOR.exe")   
;MsgBox(0, '', "Button pushed")   
Exit   
EndIf   
WEnd   
\-Copy it to C:\\attract\\EMU\\OpenBOR   
 

   
   
\-Rename openbor-folders to correct game-names ( C:\\attract\\EMU\\OpenBOR\\Night Slasher X )   
 

   
   
   
**\> scumm-vm / ScummVM**   
   
**executable           C:\\attract\\EMU\\ScummVM\\scummvm.exe**   
**args                 --config="C:\\attract\\EMU\\ScummVM\\Myscummvm.ini" -f \[name\]**   
**rompath              C:\\attract\\EMU\\ScummVM\\ROMS**   
**romext               \<DIR>**   
**system               PC**   
**info\_source          scummvm**   
**exit\_hotkey          Escape**   
   
**NOTE: to get correct game names : start scummvm.exe > add your games manually > exit scummvm > start AM > create Collection/Romlist > scrape Artwork**   
   
**NOTE : to avoid appdata configuration : scummvm.exe --config=Myscummvm.ini**   
   
   
**\> Sega 32x**   
   
**executable           C:\\attract\\EMU\\Sega 32x\\Fusion.exe**   
**args                 "\[romfilename\]" -32x -auto -fullscreen**   
**rompath              C:\\attract\\EMU\\Sega 32x\\ROMS**   
**romext               .32x**   
**system               Sega 32X**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**    
   
   
**\> Sega Dreamcast**    
   
executable           C:\\attract\\EMU\\Sega Dreamcast\\START.exe   
args                 "\[romfilename\]"   
rompath              C:\\attract\\EMU\\Sega Dreamcast\\ROMS   
romext               .cdi   
system               Sega Dreamcast   
info\_source          thegamesdb.net   
nb\_mode\_wait         5   
exit\_hotkey          Escape   
   
   
\> Sega Saturn    
   
executable           C:\\attract\\EMU\\Sega Saturn\\EmuHawk.exe   
args                 "\[romfilename\]" --fullscreen   
rompath              C:\\attract\\EMU\\Sega Saturn\\ROMS   
romext               .cue   
system               Sega Saturn   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
   
\> SNES / Super Nintendo Entertainment System / Snes9x   
   
executable           C:\\attract\\EMU\\SNES\\snes9x-x64.exe   
args                 "\[romfilename\]" -fullscreen   
rompath              C:\\attract\\EMU\\SNES\\ROMS   
romext               .smc   
system               Super Nintendo (SNES)   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
   
\> Sony PS2 / Sony Playstation2 / Sony Playstation 2    
   
executable           C:\\attract\\EMU\\Sony PS2\\pcsx2.exe   
args                 "\[romfilename\]" --fullscreen --nogui   
rompath              C:\\attract\\EMU\\Sony PS2\\ROMS   
romext               .iso;.bin;.mdf;.img   
system               Sony Playstation 2   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
   
\> Sony PS1 / Sony PSX / Sony Playstation 1 / Sony Playstation1    
   
executable           C:\\attract\\EMU\\Sony PSX\\ePSXe.exe   
args  â¯               -fullscreen -nogui -loadbin "\[romfilename\]"   
rompath              C:\\attract\\EMU\\Sony PSX\\ROMS   
romext               .cue;.iso   
system               Sony Playstation   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
   
\> Steam    
   
executable           C:\\attract\\EMU\\Steam\\Steam.exe   
args                 -applaunch \[name\]   
rompath              C:\\attract\\EMU\\Steam\\SteamApps   
romext               .acf   
system               PC   
info\_source          steam   
   
   
\> Visual Pinball    
   
executable           C:\\attract\\EMU\\Visual Pinball\\VPinballX.exe   
args                  /play "\[romfilename\]"   
rompath              C:\\attract\\EMU\\Visual Pinball\\Tables   
romext               .vpt;.vpx   
system               Arcade   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
   
\> VLC-Movies   
   
executable           C:\\Program Files\\VideoLAN\\VLC\\vlc.exe   
args                 "\[romfilename\]" --fullscreen   
rompath              C:\\attract\\EMU\\media\\MOVIES   
romext               .avi;.mpg;.mpeg;.mov;.mkv;.mp4   
info\_source          thegamesdb.net   
import\_extras        Arcade   
exit\_hotkey          Escape   
   
modify this parameters in c:\\documents and settings\\your\_username\\application data\\vlc\\vlcrc   
(on Win7 : C:\\Users\\your\_username\\AppData\\Roaming\\vlc )   
   
#3331     video-title-show=0   
#3430     osd=0   
#3322     video-on-top=1   
 

   
   
   
**\> VLC-mp3**   
   
**executable           C:\\Program Files\\VideoLAN\\VLC\\vlc.exe**   
**args                 "\[romfilename\]" --fullscreen**   
**rompath              C:\\attract\\media\\MUSIC**   
**romext               .mp3;.wav;.m3u;.ogg;.snd;.wma**   
**info\_source          thegamesdb.net**   
**import\_extras        Arcade**   
**exit\_hotkey          Escape**   
   
**create a 'main-media-folder' for all media-files**   
   
   
**\> Wii / Nintendo Wii**   
   
**executable           C:\\attract\\EMU\\Wii\\Dolphin.exe**   
**args                 -e "\[romfilename\]"  --config "Dolphin.Display.Fullscreen=True"**   
**rompath              C:\\attract\\EMU\\Wii\\ROMS**   
**romext               .iso;.wbfs**   
**system               Nintendo Wii**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
**NOTE: Dolphin creates a configuration folder in your documents-folder.**   
**But this can be undesirable if you use Dolphin with other systems (Wii, Gamecube, WAD).**   
**Just create a textfile called portable.txt in same folder, where Dolphin.exe is found.**   
   
   
**\> windows\_games**   
   
**executable           cmd**   
**args                 /c "\[romfilename\]"**   
**rompath              C:\\attract\\EMU\\windows\_games/roms**   
**romext               .lnk;.bat**   
   
**create a 'main-folder' for all games/roms; create to this folder shortcuts/link-files (.lnk) of your exe-files**   
 

   
   
   
**\> WinKawaks**   
   
**executable           "WinKawaks.exe"**   
**args                 \[name\] -fullscreen**   
**workdir              C:\\attract\\EMU\\WinKawaks**   
**rompath              C:\\attract\\EMU\\WinKawaks\\roms**   
**romext               .zip**   
**system               Arcade**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
**Note : to get artwork :**    
**create a second mame installation > rename it to WinKawaks > copy your rom files to rom-folder > start AM > create romlist > scrape artwork > close AM > remove second mame installation or replace everything with WinKawaks installation files**   
   
**executable           C:\\attract\\EMU\\WinKawaks\\mame.exe**   
**args                 \[name\] -skip\_gameinfo**   
**rompath              C:\\attract\\EMU\\WinKawaks\\roms**   
**romext               .zip;.7z;\<DIR>**   
**system               Arcade**   
**info\_source          listxml**   
**exit\_hotkey          Escape**   
**artwork    marquee         C:\\attract\\scraper\\WinKawaks\\marquee**   
**artwork    snap            C:\\attract\\scraper\\WinKawaks\\video;C:\\attract\\scraper\\WinKawaks\\flyer**   
   
   
**\> ZSNES / SNES / Super Nintendo Entertainment System**   
   
**executable           C:\\attract\\EMU\\zsnes\\zsnesw.exe**   
**args                 -m "\[romfilename\]"**   
**rompath              C:\\attract\\EMU\\zsnes\\ROMS**   
**romext               .smc**   
**system               Super Nintendo (SNES)**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
**Note : in znes > config > video > choose your resolution of choice with DS and F (allow Filters, Stretch and Fullscreen)**   
 

   
   
   
**\> ZX Spectrum / Sinclair ZX Spectrum**   
   
**executable           C:\\attract\\EMU\\ZX Spectrum\\fuse.exe**   
**args                 --full-screen "\[romfilename\]" --disk-try-merge always**   
**rompath              C:\\attract\\EMU\\ZX Spectrum\\ROMS**   
**romext               .dsk;.tap**   
**system               Sinclair ZX Spectrum**   
**info\_source          thegamesdb.net**   
**exit\_hotkey          Escape**   
   
**NOTE : to get fullscreen parameter, you need the fuse-1.5.1-sdl.zip.** [**Here**](https://drive.google.com/drive/folders/0B_2W9q0zVYtdWjBKSEpxWFMwNFE)   
 

   
   
**\> SuFami Turbo via ZSNES**    
   
executable           C:\\attract\\EMU\\SuFami Turbo\\zsnesw.exe   
args                 -m "\[romfilename\]"   
rompath              C:\\attract\\EMU\\SuFami Turbo\\ROMS   
romext               .st   
system               Super Nintendo (SNES)   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
NOTE : you need stbios.bin (filesize : 256 kb) or downoad Sufami BIOS.smc (same size; rename the file to stbios.bin). Set path to this file in ZSNES.   
start Zsnes > Config > Paths > Sufami Turbo : Path\_to\_file\\stbios.bin   
   
NOTE : with ZSNES and Snex9X, you only could import one cartridge.    
So you can't share data between two games/cartridges.   
   
   
\> SuFami Turbo via BSNES   
   
NOTE : with BSNES, you can use Sufami Turbo crossplay / share data between two games/cartridges.   
[use version v1.15](https://github.com/bsnes-emu/bsnes/releases/tag/v115)   
 [](https://github.com/bsnes-emu/bsnes/releases/tag/v115)   
NOTE : use this autoit script (START.au3), to import two games in AM:   
   
executable           C:\\attract\\EMU\\SuFami Turbo\\START.exe   
args                 "\[romfilename\]"   
rompath              C:\\attract\\EMU\\SuFami Turbo\\ROMS   
romext               .st   
system               Super Nintendo (SNES)   
info\_source          thegamesdb.net   
exit\_hotkey          Escape   
   
 

Code: \[Select\] 

#include \<MsgBoxConstants.au3>   
#include \<Misc.au3>   
   
$EXECUTABLE = "C:\\attract\\EMU\\SuFami Turbo\\bsnes.exe"   
$ROMPATH = "C:\\attract\\EMU\\SuFami Turbo\\ROMS\\"   
$BIOSPATH = "C:\\attract\\EMU\\SuFami Turbo\\BIOS\\bios.rom"   
   
; read FIRST GAME and set .whatever behind   
Local $hSearch = FileFindFirstFile($ROMPATH & "\*.whatever")   
Local $sFileName = "", $iResult = 0   
   
While 1   
$sFileName = FileFindNextFile($hSearch)   
   
If @error Then   
; if no .whatever file exists, then create FIRST GAME with .whatever   
FileWrite($CmdLine\[1\]&".whatever",$CmdLine\[1\]&".whatever")   
Exit   
ExitLoop   
EndIf   
   
If $iResult \<> $IDOK Then ExitLoop   
WEnd   
FileClose($hSearch)   
   
; if FIRST GAME with .whatever exists, then start BSNES with FIRST GAME and SECOND GAME   
; bsnes.exe + path to bios.rom + read txt from FIRST GAME (cut .whatever) + get SECOND GAME from cmdline   
run('"' & $EXECUTABLE & '"' & " --fullscreen -st " & '"'& $BIOSPATH & '"' & " " & '"' & StringTrimRight($ROMPATH & $sFileName,9) & '"' & " " & '"' & $CmdLine\[1\] & '"')   
   
   
; move Mouse from center   
MouseMove(2000, 308, 0)   
FileDelete($ROMPATH & $sFileName)   
   
; wait for ESC, then exit BSNES   
While 1   
If \_IsPressed ("1B") Then   
ProcessClose("bsnes.exe")   
Exit   
EndIf   
WEnd
