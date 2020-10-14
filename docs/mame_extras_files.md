## Support Files

Optional support files enhance your MAME experience by providing information about arcade game design, history, technology, and trivia.

### Artwork

In addition to the images created by their programs, some games used physical artwork such as printed background images, transparent overlays, and bezels (cabinet artwork surrounding the monitor). To reproduce this physical art, MAME utilizes Artwork files. To obtain these files, you can download them from the [official MAME site](http://www.mame.net/downart.html) or search the Internet for alternative download sites. Extract the Artwork files to your MAME folder's "artwork" subfolder.

### Samples

A very small percentage of ROMs that MAME supports (less than 1%) require sound samples in order for all sound effects to be heard properly. This may be due to incomplete knowledge of a game's sound architecture, or a game's use of analog sounds rather digital. These sampled-sound WAV files are freely distributable. You can download them from [MAME's official homepage](http://www.mame.net/downsamples.html) or from [Twisty's MAME Samples Collection page](http://www.mameworld.net/samples/). Twisty's sample collection includes some digitally-enhanced sample versions. Extract Samples files to the "samples" subfolder of your main MAME folder.

### Mameinfo

The Mameinfo.dat file is a record of information pertaining to each game and its history of support throughout MAME. It contains records about bugs and developments (work-in-progress reports) for particular games, as well as related information such as play instructions, story background, the number of levels in a game, related or similar games, drivers and related source code, as well as other emulators that are available which also play a game that you're examining. Not every bit of information is as useful as others, but on the whole, it provides a very comprehensive look at a game and can be particularly helpful if you've never heard of a particular game before. You can find it at the [official Mameinfo site](http://www.mameworld.net/mameinfo/) and it lives in the same directory as your MAME executable.

### High Scores

One of arcade gaming's biggest thrills is gunning for a game's current high score. Later games preserved their high scores in special types of memory that persisted when the machines were turned off. Earlier machines lacked this ability, so their high scores were erased when their screens went dark---a trait MAME authentically reproduces. To preserve your high scores in most (but not all) of these earlier games, you can add a special hiscore.dat file to your MAME installation. Download the file from [unofficial Highscore.dat site](http://www.mameworld.net/highscore/) and extract it to your main MAME folder.

### Cheat

So a game that you're playing is just a little too tough. This is the thousandth time that you've played it, and you just want to make it to that next board for the first time. Enter the cheat.dat, a file that enables you to give yourself infinite lives, or invulnerability. If the method to unlock a cheat in MAME has been found, it's in this file. Bear in mind that the cheat you desire may not necessarily be in the cheat.dat if the ability to activate that cheat has not been discovered. But all of the more popular games are well represented. Remember that you have to enable cheats in the Game Properties dialog, and you can use the F6 key (by default) to toggle the use of cheats on and off. You also need to enter the in-game MAME menu to toggle which cheats you would like to activate. You can find the cheat.dat file at [Pugsy's MAME Cheat page](http://cheat.retrogames.com/) and it lives in the same directory as your MAME executable.

### Command

The command.dat is a support file who's primary purpose is to let you know what various commands exist for the different games that you play. Consequently, a majority of the content in the file pertains to the special moves of fighting games. Additionally, small guides or FAQs have been added to file to provide in-game support to players. It is maintained by [Procyon Lotor](https://strategywiki.org/wiki/User:Procyon), and contributed to by many authors around the world. Support for this file has been added to MAME32Plus, and has been in and out of other derivative builds of MAME over time. Constant changes to the rendering engine make maintaining support for the command.dat difficult. A few front-ends have also incorporated support for the command.dat as well. In order to access the command.dat while playing on MAME32Plus, you must press Tab and choose the _Game Documentation_ option, and then _Show Commands_. From here, you may see another selection menu (such as the name of each street fighter), which is the command.dat's way of breaking up and organizing all of the information it contains. You can learn more about, and download, the command.dat file at [Procyon Lotor's homepage](http://home.comcast.net/~plotor/command.html).

## Front-End only support files

Some support files are not supported directly by any of the MAME variants or derivatives, but rather by front-ends written to support MAME.

### History

The History.dat files contains historical accounts of the games that MAME supports, including development, financial success, technical and scoring info, and random bits of trivia. Unlike Mameinfo.dat, which describes each game's MAME emulation, the info in History.dat pertains to the original arcade games. The combination of Mameinfo.dat and History.dat will tell you just about everything you want to know about MAME-supported games. You can download History.dat from the [official History.dat site](http://www.arcade-history.com/).

### Catlist

One of MAME's main purposes is to be an historical database for arcade games. MAME32 and similar frontends do a great job of organizing this information. You can organize your games even further by using special category lists ("catlists") available at the [official Catlist repository](http://www.mameworld.net/catlist/). Several specialized lists are available; it also explains how to make your own. The locations for catlist files vary for different frontends, so please see your frontend's instructions for installation details. In MAME32, Catlists have been replaced by the ini files in the "folders" directory, which are not compatible with the catlist.ini format.

### NPlayers

The NPlayers.ini is very much like the catlist files except that it serves only one specific purpose: NPlayers.ini fills the "Players" column of your favourite MAME frontend letting you know how many players the game supports and if it's simultaneous play or not. If you are using a front end that supports the NPlayers.ini, you can find it at the [official NPlayers.ini site](http://nplayers.arcadebelgium.be/). Placement of the file varies for different front-ends that are programmed to make use of these ini files, so please read your front-end's instructions.

### Controls

Controls.ini is a project started by Kevin Jonas (SirPoonga) with the help of Howard Casto. This project was started to accurately document the controls and button labels of the arcade control panels from the games in MAME. Like the Catlist and NPlayers files, you can only use the controls.ini with a front-end that is programmed to use it.

## Art Files

Art files are those files which are generally used by GUIs and front-ends to show previews of game screenshots and artwork from the machines themselves before you select a game. Unlike the support files above, each of the art files are actually entire groups of image files that map to games that MAME supports. They can typically be compressed in to one giant zip file, but since the images are already compressed, the payoff is small, and the ease of management decreases when updates are released.

### Flyers

![](https://cdn.wikimg.net/en/strategywiki/images/thumb/7/74/MPM_Flyer.png/300px-MPM_Flyer.png)

Ms. Pac-Man Flyer

Flyers are essentially advertisements or trade announcements meant to entice arcade operators in to buying the latest game that a company has produced. They typically feature large amounts of artwork and a number of screenshots, along with some marketing slogan meant to hype the game. MAME32, all MAME32 derivatives, and just about all Front-Ends can display flyers if you download the flyerpacks to the "flyers" folder in the MAME directory. You can download flyerpacks from [The Arcade Flyer Archive](http://www.arcadeflyers.com/).

### Marquees

![](https://cdn.wikimg.net/en/strategywiki/images/thumb/9/9c/DK_Marquee.jpg/300px-DK_Marquee.jpg)

Donkey Kong Marquee

Marquees were the hard plastic backlit signs that adorned the tops of upright arcade cabinets. They were usually the first things your eyes were drawn to from a distance. Since you couldn't yet see the screen, the marquee was your first indication as to what games were present. MAME32, all MAME32 derivatives, and just about all Front-Ends can display marquees if you download the marquee packs to the "marquees" folder in the MAME directory. You can download marquee packs from the very simple [EMAM's Marquees site](http://emam.mameworld.net/).

### Mamu Icons

![](https://cdn.wikimg.net/en/strategywiki/images/b/b6/MAMu_-Web-Design_small.png)

MAMu\_ Web Design

Mamu is an exceptionally talented pixel and Flash artist who has done a fantastic job capturing the essence of an entire arcade game in a single icon. Regretfully, he has not been able to make updates on a consistent basis, but the supply of icons he has made available are exceptionally well done. MAME32, all MAME32 derivatives, and just about all Front-Ends can utilize icons if you download them to the "icons" folder in the MAME directory. Head over to [MAMu\_'s MAME Icons site](http://icons.mameworld.info/) and grab them.

### MAMEUI Icons

The "official" MAMEUI icons offered at the [MAMEUI Home Page](http://www.mameui.info) are not quite as refined as Mamu's icons, and many of them have little to do with the games they apply to. However, icons of some kind are usually included for all currently-supported games. Many users compromise by installing these "official" icons, then installing Mamu's icons over them.

### Snapshots

![](https://cdn.wikimg.net/en/strategywiki/images/d/d3/MB_Stage2.png)

Mario Bros. snapshot

The ultimate way to preview a game before you start playing it, snapshots allow you to look at what the game your about to play looks like before you try it out. This can sometimes help you "put a face to the name," in case all that you can remember is what a game looked like, despite not remembering the name of it. MAMEUI, all MAMEUI derivatives, and just about all frontends can display snapshots if you download snapshot packs to the "snaps" folder in the MAME directory. The "official" snapshots are available for download at the [MAMEUI Home Page](http://www.mameui.info).

### HitF12

HitF12 (a reference to MAME's screen-capture key, F12) is an alternative Snapshot collection. Rather than using random game images, HitF12's goal is to capture a defining moment of each game, in its original resolution and color depth. The HitF12 collection is available at [HitF12 homepage](http://www.mameworld.info/hitf12/). Download each pack and extract it to your MAME folder's "snaps" subfolder.

### Title Screens

![](https://cdn.wikimg.net/en/strategywiki/images/6/65/DKJR_Title.png)

Donkey Kong Jr. title screen

Title Screens are screenshots of each game's opening screen, showing its name. MAME Title Screens are currently available at the [MAME Titles site](http://www.mametitles.com/). (Note that this site relies on Bit Torrent to distribute most of images; however, it usually includes links to other sites offering direct downloads.) Download the Title Screen packs and extract them to your MAME folder's "titles" subfolder.

### Cabinets

Like the marquees, images of cabinets and the artwork they contain usually trigger memories of visiting a real arcade. Several arcade cabinet photographs are available for download at the [MAMEUI Home Page](http://www.mameui.info/). MAMEUI, all MAMEUI derivatives, and just about all frontends can display snapshots if you download cabinet packs to the "cabinets" folder in the MAME directory.

### Panels

![](https://cdn.wikimg.net/en/strategywiki/images/thumb/7/72/QB_Controls.png/300px-QB_Controls.png)

Q\*Bert control panel

As with cabinets and marquees, control panels serve as the final image that make up the a complete arcade visual. More than just reminding you of how a cabinet used to look however, they can also clarify exactly what sort of input you should expect to use, or the layout of particularly placed buttons. MAME32, all MAME32 derivatives, and just about all Front-Ends can display control panel images if you download panel packs to the "cpanel" folder in the MAME directory. The home for control panel images has bounced around, but user known as Mr. Do has adopted them and made them available on his [control panel page](http://www.mameworld.net/mrdo/mamepanel.html). Incidentally, Mr. Do has also provides alternative high quality arcade cabinet pictures on his [Cabinet Pics project page](http://www.mameworld.net/mrdo/cabpics.html).
