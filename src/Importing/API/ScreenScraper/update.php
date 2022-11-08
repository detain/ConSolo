<?php
/**
* grabs latest ScreenScraper.fr data and updates db
*/

/* Current Output
        "1": {
            "id": 1,
            "name": "Genesis",
            "altNames": [
                "Megadrive"
            ],
            "company": "SEGA",
            "matches": {
                "launchbox": [
                    "Sega Genesis"
                ],
                "retropie": [
                    "genesis",
                    "megadrive"
                ],
                "recalbox": [
                    "megadrive"
                ]
            }
        },
*/
/* API Response
    {
        "id": 1,
        "noms": {
            "nom_eu": "Megadrive",
            "nom_us": "Genesis",
            "nom_recalbox": "megadrive",
            "nom_retropie": "genesis,megadrive",
            "nom_launchbox": "Sega Genesis",
            "nom_hyperspin": "Sega Genesis",
            "noms_commun": "Sega Megadrive,Sega Genesis,Megadrive,Genesis,Super Aladdin Boy"
        },
        "extensions": "gen,md,smd,bin,sg",
        "compagnie": "SEGA",
        "type": "Console",
        "datedebut": "1988",
        "datefin": "1998",
        "romtype": "rom",
        "supporttype": "cartouche",
        "medias": [
            {
                "type": "logo-monochrome",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=logo-monochrome(br)",
                "region": "br",
                "crc": "85be4a0e",
                "md5": "69e98b292ffeedfa1ed19fd556492df5",
                "sha1": "de678ddec48cdf8d048d02edc6bbe05dad636260",
                "format": "png"
            },
            {
                "type": "logo-monochrome",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=logo-monochrome(jp)",
                "region": "jp",
                "crc": "88b1aa38",
                "md5": "3747a8306060fd8b4d59bca158667273",
                "sha1": "4f21501bb332a0d24b7c9b9f095028a8e8653db5",
                "format": "png"
            },
            {
                "type": "logo-monochrome",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=logo-monochrome(us)",
                "region": "us",
                "crc": "1d9c1601",
                "md5": "48b1900b6567c1ac3f2e292bec1ca791",
                "sha1": "bda3367f86da4e43c8bbde9b69314a846e7e0cbe",
                "format": "png"
            },
            {
                "type": "logo-monochrome",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=logo-monochrome(wor)",
                "region": "wor",
                "crc": "d3091696",
                "md5": "ec3d29523defb5f296b158f307d35cad",
                "sha1": "be327c6b2a5c78b060e27ded4189205530714e3f",
                "format": "png"
            },
            {
                "type": "wheel",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel(asi)",
                "region": "asi",
                "crc": "00aaeb7f",
                "md5": "736e190a6648910529bedd3018a664d3",
                "sha1": "b852d6d4762af2ce39e016f39187665f98a3694f",
                "format": "png"
            },
            {
                "type": "wheel",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel(br)",
                "region": "br",
                "crc": "6154854a",
                "md5": "8ea8be36d74da6c3c8076aa9dc2edfa0",
                "sha1": "a3cc7a18b9f83233f439154afa1d709b60baf7c2",
                "format": "png"
            },
            {
                "type": "wheel",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel(jp)",
                "region": "jp",
                "crc": "a945d317",
                "md5": "059c4bde91cb860d0631282ba4b5a3d0",
                "sha1": "9276e8af03d414c3be3dd080034073428f0ace59",
                "format": "png"
            },
            {
                "type": "wheel",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel(us)",
                "region": "us",
                "crc": "df3198be",
                "md5": "0f61378b2abbc09f303900612a26cc35",
                "sha1": "93506b49938cad0218b72316a9edc9b69ecd30de",
                "format": "png"
            },
            {
                "type": "wheel",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel(wor)",
                "region": "wor",
                "crc": "85832e9c",
                "md5": "668b1201f280946b24cad28593da321a",
                "sha1": "b42b877f8805efedb5c685570285dd2fe1c84d68",
                "format": "png"
            },
            {
                "type": "wheel",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel(wor)",
                "region": "eu",
                "crc": "85832e9c",
                "md5": "668b1201f280946b24cad28593da321a",
                "sha1": "b42b877f8805efedb5c685570285dd2fe1c84d68",
                "format": "png"
            },
            {
                "type": "wheel-carbon",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel-carbon(jp)",
                "region": "jp",
                "crc": "763c0f97",
                "md5": "fe9d2622d1b67a28bd7fff634bfb4694",
                "sha1": "e8ee2aec2f88d10a2dd3e5ad362b4111c857a8a6",
                "format": "png"
            },
            {
                "type": "wheel-carbon",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel-carbon(us)",
                "region": "us",
                "crc": "a65e385e",
                "md5": "05016d3b85c8d411a9c066249d02f6c0",
                "sha1": "76e7b416bcd6c85b121eff162fa1010ef2e3cf3f",
                "format": "png"
            },
            {
                "type": "wheel-carbon",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel-carbon(wor)",
                "region": "wor",
                "crc": "181cba7e",
                "md5": "720c18fa28826fb866a583f35173693b",
                "sha1": "e9eb9f355c96d67417687407d3b224825a977e62",
                "format": "png"
            },
            {
                "type": "wheel-carbon-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel-carbon-vierge(wor)",
                "region": "wor",
                "crc": "68139410",
                "md5": "b72f50ca080d50fe330adbd844f16ec5",
                "sha1": "a239fda4415fbe55d4a86a41b39e9737d3428a83",
                "format": "png"
            },
            {
                "type": "wheel-steel",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel-steel(jp)",
                "region": "jp",
                "crc": "eb59cdb1",
                "md5": "1f08099b4f41e58fc9c9c71d6b8496d4",
                "sha1": "f7fa2ea10e431642fb4386df81a06a8b400cc185",
                "format": "png"
            },
            {
                "type": "wheel-steel",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel-steel(us)",
                "region": "us",
                "crc": "248aff72",
                "md5": "374beb8a49ae8c7b14ddc6dca719a42f",
                "sha1": "3dc51b701cf7c4064d62486248a3c0aed4007f7c",
                "format": "png"
            },
            {
                "type": "wheel-steel",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel-steel(wor)",
                "region": "wor",
                "crc": "46adbfd7",
                "md5": "e3fb225ddd8866b236b31477b6adf82a",
                "sha1": "68e428c6fa0e8c7249bc70dca57306c3d28522e7",
                "format": "png"
            },
            {
                "type": "wheel-steel-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=wheel-steel-vierge(wor)",
                "region": "wor",
                "crc": "1f3feeb7",
                "md5": "ecdc80f360ddc6a215a7333cb53eb95b",
                "sha1": "4aa073bf5dfe58997e0ad042f72c28bd30aeb5ca",
                "format": "png"
            },
            {
                "type": "minicon",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=minicon",
                "crc": "fbc851ef",
                "md5": "4afa8cbe5a7e3d2bb923d214fad21ded",
                "sha1": "e256a595f3da2c710dbc8f3172a03fdf9a94cf62",
                "format": "png"
            },
            {
                "type": "icon",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=icon",
                "crc": "ccb76fbb",
                "md5": "2284a80b3386eb7c1069d4bc67b43e68",
                "sha1": "ba217e79c9099cbe75b9590bcd74dcb21ddba3d8",
                "format": "png"
            },
            {
                "type": "photo",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=photo(br)",
                "region": "br",
                "crc": "1a3d1f3b",
                "md5": "c89df659ecc898d661a8143e80ea5393",
                "sha1": "de31df6033a466be55b1e4e364ee4049664c5290",
                "format": "png"
            },
            {
                "type": "photo",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=photo(jp)",
                "region": "jp",
                "crc": "16fd5779",
                "md5": "053771e815640b0b2d87a9ee69c6291a",
                "sha1": "5c32c6095450e4d4ca1d1086bef88dbc06586fe4",
                "format": "png"
            },
            {
                "type": "photo",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=photo(us)",
                "region": "us",
                "crc": "e21fe422",
                "md5": "2ededa879f95dddb2cec476546286c5a",
                "sha1": "b554ec71cb717b58d1aef67dc90743cab21729dd",
                "format": "png"
            },
            {
                "type": "photo",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=photo(wor)",
                "region": "wor",
                "crc": "4d9b828a",
                "md5": "f9b16eb62b240c6aabe933ba653c4b95",
                "sha1": "1bf3d5aa7f4744faf354593bb5c0fb1acbc0f476",
                "format": "png"
            },
            {
                "type": "illustration",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=illustration(asi)",
                "region": "asi",
                "crc": "28eb5daa",
                "md5": "df9d7dddc1180a0f73b753f1f1141fed",
                "sha1": "195d0d9e3a86e0f6478a93ae3fe313e561a82352",
                "format": "png"
            },
            {
                "type": "illustration",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=illustration(br)",
                "region": "br",
                "crc": "89b529b3",
                "md5": "a2b056f99c1afc348b6d4998877c1728",
                "sha1": "04934c57423f850afd19a36fe159f8345daf5093",
                "format": "png"
            },
            {
                "type": "illustration",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=illustration(eu)",
                "region": "eu",
                "crc": "00b621ca",
                "md5": "39c9245a0f0bfe2ca88bb85e40f6951a",
                "sha1": "d8e9218b447a8b6caebc02926709ca111a133d69",
                "format": "png"
            },
            {
                "type": "illustration",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=illustration(us)",
                "region": "us",
                "crc": "d1031bad",
                "md5": "7c505d90e237c521d0c841f9f9baee3f",
                "sha1": "efa84d12160528da1ba5ec47c1e454e2a7c2fde3",
                "format": "png"
            },
            {
                "type": "controller",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controller(us)",
                "region": "us",
                "crc": "8bfc1176",
                "md5": "fdc628d776929d25c4e385a243b55d7b",
                "sha1": "58696a18861b5d03af2b5b4a8c6d28b440b53c31",
                "format": "png"
            },
            {
                "type": "controller",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controller(wor)",
                "region": "wor",
                "crc": "b9a46163",
                "md5": "9b2bdd5e559264e76f97ade494f55cdb",
                "sha1": "e6de7d43afc503da07fc6674e59bceab4045c027",
                "format": "png"
            },
            {
                "type": "video",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaVideoSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=video",
                "crc": "56406518",
                "md5": "5e6f19b5d1928b36a8e0ca97cdd7696f",
                "sha1": "a80e06f1b42c304a6163ac97785595857fc57d7f",
                "format": "mp4"
            },
            {
                "type": "steam-grid",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=steam-grid",
                "crc": "a6391b8a",
                "md5": "c7132cec089179f0b955e61ac5ec4204",
                "sha1": "680559fa841554d56001c0a20810db53bdf1fa15",
                "format": "png"
            },
            {
                "type": "BoitierConsole3D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=BoitierConsole3D(fr)",
                "region": "fr",
                "crc": "738ed922",
                "md5": "81b7cfc7c8f6da346358a46606a8d7bc",
                "sha1": "c5d0561222d418854697d9eca420b02056362e0c",
                "format": "png"
            },
            {
                "type": "BoitierConsole3D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=BoitierConsole3D(jp)",
                "region": "jp",
                "crc": "cf36c865",
                "md5": "f7525e9a02098a4e9e0046cdd91380dc",
                "sha1": "87e75ec83344b65d40e0f18cdc50fd4c75269b42",
                "format": "png"
            },
            {
                "type": "background",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=background(wor)",
                "region": "wor",
                "crc": "423f6354",
                "md5": "5d098e2b3ed7e3d4af7b7d1f0352ae5a",
                "sha1": "4770000221584fb99e8194ce97b973b6522b15e8",
                "format": "png"
            },
            {
                "type": "screenmarquee",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=screenmarquee(wor)",
                "region": "wor",
                "crc": "346b2a4f",
                "md5": "f99984629f17cbf182ff9a51afbda4e5",
                "sha1": "7a7946055ee297394e0b279eb18f1795c52c4e1d",
                "format": "png"
            },
            {
                "type": "screenmarquee-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=screenmarquee-vierge(wor)",
                "region": "wor",
                "crc": "4529cb64",
                "md5": "1946859c5f1844fdcfe617c9ced6580f",
                "sha1": "26dfab610a5506fe0ad491d19f4afe516d7a03fc",
                "format": "png"
            },
            {
                "type": "bezel-4-3",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=bezel-4-3(cus)",
                "region": "cus",
                "crc": "f104d8d5",
                "md5": "7515f087bb04fc65bd4391745577c447",
                "sha1": "0fe54f2ce196cfb5237152cce912840dcb09c1bb",
                "posx": "142",
                "posy": "27",
                "posw": "745",
                "posh": "713",
                "format": "png"
            },
            {
                "type": "bezel-4-3",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=bezel-4-3(jp)",
                "region": "jp",
                "crc": "ce454a20",
                "md5": "b825ae0938e38f37d1d80a59021573b0",
                "sha1": "6ab26c9c6181a5f5344c3e9cef1104fd2e9107d3",
                "posx": "142",
                "posy": "27",
                "posw": "745",
                "posh": "713",
                "format": "png"
            },
            {
                "type": "bezel-4-3",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=bezel-4-3(wor)",
                "region": "wor",
                "crc": "4e4e8e6e",
                "md5": "9bd1f70d3e94fe11d4ad2ea238ddc8a4",
                "sha1": "80910166916435c7b39abc7eea8ad016f7dc23b5",
                "posx": "142",
                "posy": "27",
                "posw": "745",
                "posh": "713",
                "format": "png"
            },
            {
                "type": "bezel-16-9",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=bezel-16-9(jp)",
                "region": "jp",
                "crc": "627550c7",
                "md5": "bc1c8f149049e76da01d39419d16a298",
                "sha1": "90e46ae5818354ae0138f24ed44817f1011092a2",
                "posx": "251",
                "posy": "0",
                "posw": "1421",
                "posh": "1079",
                "format": "png"
            },
            {
                "type": "bezel-16-9",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=bezel-16-9(us)",
                "region": "us",
                "crc": "2bc33f0b",
                "md5": "fccf53f1b872a348581b2086ae47b0d6",
                "sha1": "fbc7033c3545b9832d50551f029cb6119b05901a",
                "posx": "251",
                "posy": "10",
                "posw": "1415",
                "posh": "1060",
                "format": "png"
            },
            {
                "type": "bezel-16-9",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=bezel-16-9(wor)",
                "region": "wor",
                "crc": "d6b8afb9",
                "md5": "33dbb1066d3df7529fa1eed06c018f9a",
                "sha1": "69b9cd09887cc6145f783e0fcfe675b5152a7b0d",
                "format": "png"
            },
            {
                "type": "box-back-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-back-vierge(ss)",
                "region": "ss",
                "crc": "08498cd0",
                "md5": "31999f41dc46091ef5910c60bbae801f",
                "sha1": "128133df79a66b4befefb7f0d651d8542cb64d07",
                "ssx": "289",
                "ssy": "403",
                "ssw": "159",
                "ssh": "110",
                "ssrotation": "0",
                "sstitlex": "289",
                "sstitley": "255",
                "sstitlew": "159",
                "sstitleh": "110",
                "sstitlerotation": "0",
                "wheelx": "9",
                "wheely": "98",
                "wheelw": "463",
                "wheelh": "57",
                "wheelrotation": "0",
                "titrex": "9",
                "titrey": "98",
                "titrew": "463",
                "titreh": "57",
                "titretypo": "NiseGenesis.TTF",
                "titrerotation": "0",
                "titretyposizemax": "60",
                "titrecouleur": "FFFFFF",
                "titreMaj": "non",
                "descriptionx": "10",
                "descriptiony": "167",
                "descriptionw": "251",
                "descriptionh": "364",
                "descriptiontypo": "AGENCYB.TTF",
                "descriptionrotation": "0",
                "descriptiontyposizemax": "12",
                "descriptioncouleur": "FFFFFF",
                "descriptionMaj": "non",
                "format": "png"
            },
            {
                "type": "box-tranche-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-tranche-vierge(asi)",
                "region": "asi",
                "crc": "8332d6eb",
                "md5": "a894c0305c7a3934f02cba9f8443a119",
                "sha1": "ded2ea9c34437b618f26a1f6230bc27f94db2f6d",
                "wheelx": "3",
                "wheely": "44",
                "wheelw": "91",
                "wheelh": "358",
                "wheelrotation": "270",
                "titrex": "3",
                "titrey": "44",
                "titrew": "91",
                "titreh": "360",
                "titretypo": "NiseGenesis.TTF",
                "titrerotation": "270",
                "titretyposizemax": "20",
                "Titrecouleur": "FFFFFF",
                "TitreMaj": "non",
                "format": "png"
            },
            {
                "type": "box-tranche-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-tranche-vierge(br)",
                "region": "br",
                "crc": "70e946e4",
                "md5": "f35a4dab00e5123b21958f1d2ff64ddf",
                "sha1": "eb5ad6dd6e840b5e99ce98ce0485fba0cf983ff3",
                "wheelx": "4",
                "wheely": "46",
                "wheelw": "86",
                "wheelh": "351",
                "wheelrotation": "270",
                "titrex": "3",
                "titrey": "44",
                "titrew": "91",
                "titreh": "360",
                "titretypo": "NiseGenesis.TTF",
                "titrerotation": "270",
                "titretyposizemax": "20",
                "Titrecouleur": "FFFFFF",
                "TitreMaj": "non",
                "format": "png"
            },
            {
                "type": "box-tranche-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-tranche-vierge(eu)",
                "region": "eu",
                "crc": "33e7be21",
                "md5": "088020f5edc275b404d9b5a553664e0a",
                "sha1": "8f18621eca356a51ee2b0af6ad3d337363eea66f",
                "wheelx": "9",
                "wheely": "63",
                "wheelw": "80",
                "wheelh": "390",
                "wheelrotation": "270",
                "titrex": "3",
                "titrey": "44",
                "titrew": "91",
                "titreh": "360",
                "titretypo": "NiseGenesis.TTF",
                "titrerotation": "270",
                "titretyposizemax": "20",
                "Titrecouleur": "FFFFFF",
                "TitreMaj": "non",
                "format": "png"
            },
            {
                "type": "box-tranche-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-tranche-vierge(jp)",
                "region": "jp",
                "crc": "2c752d29",
                "md5": "c5732c70af7c87101ea012828525f1dc",
                "sha1": "9ca3404f366b18634d7a6add274e2466f99f8558",
                "wheelx": "9",
                "wheely": "63",
                "wheelw": "80",
                "wheelh": "390",
                "wheelrotation": "270",
                "titrex": "3",
                "titrey": "44",
                "titrew": "91",
                "titreh": "360",
                "titretypo": "NiseGenesis.TTF",
                "titrerotation": "270",
                "titretyposizemax": "20",
                "Titrecouleur": "000000",
                "TitreMaj": "non",
                "format": "png"
            },
            {
                "type": "box-tranche-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-tranche-vierge(ss)",
                "region": "ss",
                "crc": "b16248df",
                "md5": "b874d020cd9932f9096dcfb9c5ea3526",
                "sha1": "d7e6c5d1ae54b427afcebf90fa1473602072f35c",
                "wheelx": "3",
                "wheely": "44",
                "wheelw": "91",
                "wheelh": "366",
                "wheelrotation": "270",
                "titrex": "3",
                "titrey": "44",
                "titrew": "91",
                "titreh": "360",
                "titretypo": "NiseGenesis.TTF",
                "titrerotation": "270",
                "titretyposizemax": "20",
                "Titrecouleur": "FFFFFF",
                "TitreMaj": "non",
                "format": "png"
            },
            {
                "type": "box-tranche-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-tranche-vierge(us)",
                "region": "us",
                "crc": "b16248df",
                "md5": "b874d020cd9932f9096dcfb9c5ea3526",
                "sha1": "d7e6c5d1ae54b427afcebf90fa1473602072f35c",
                "wheelx": "3",
                "wheely": "44",
                "wheelw": "91",
                "wheelh": "366",
                "wheelrotation": "270",
                "titrex": "3",
                "titrey": "44",
                "titrew": "91",
                "titreh": "360",
                "titretypo": "NiseGenesis.TTF",
                "titrerotation": "270",
                "titretyposizemax": "20",
                "Titrecouleur": "FFFFFF",
                "TitreMaj": "non",
                "format": "png"
            },
            {
                "type": "box-tranche-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-tranche-vierge(wor)",
                "region": "wor",
                "crc": "60ceda03",
                "md5": "1e8b3c99fb04bb8fb7cb576b5e8e4ff5",
                "sha1": "481dc7ab5ae6b606d1a87fb96d0b538d73b5ea24",
                "wheelx": "3",
                "wheely": "44",
                "wheelw": "91",
                "wheelh": "330",
                "wheelrotation": "270",
                "titrex": "3",
                "titrey": "44",
                "titrew": "91",
                "titreh": "360",
                "titretypo": "NiseGenesis.TTF",
                "titrerotation": "270",
                "titretyposizemax": "20",
                "Titrecouleur": "000000",
                "TitreMaj": "non",
                "format": "png"
            },
            {
                "type": "box-vierge",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-vierge(ss)",
                "region": "ss",
                "crc": "017b660e",
                "md5": "fbd99d3ec00e36993bbe4d0dce2f35b6",
                "sha1": "1bb20813198ace1bcd1be46d8b1334ffd7274d29",
                "ssx": "93",
                "ssy": "0",
                "ssw": "391",
                "ssh": "588",
                "ssrotation": "0",
                "wheelx": "98",
                "wheely": "574",
                "wheelw": "375",
                "wheelh": "95",
                "wheelrotation": "0",
                "titrex": "13",
                "titrey": "596",
                "titrew": "463",
                "titreh": "75",
                "titretypo": "NiseGenesis.TTF",
                "titrerotation": "0",
                "titretyposizemax": "60",
                "Titrecouleur": "FFFFFF",
                "titreMaj": "non",
                "format": "png"
            },
            {
                "type": "box3D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box3D(wor)",
                "region": "wor",
                "crc": "eb1ca881",
                "md5": "2f3883d5484a1d43081ab2169b1026cc",
                "sha1": "c4d9d48587220a608cbf34033db717dc7724eb25",
                "destavantx": "58",
                "destavanty": "10",
                "destavantw": "256",
                "destavanth": "570",
                "avantpers": "0.78",
                "destcotex": "10",
                "destcotey": "7",
                "destcotew": "49",
                "destcoteh": "576",
                "cotepers": "0.88",
                "format": "png"
            },
            {
                "type": "box-texture-gabarit",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=box-texture-gabarit(wor)",
                "region": "wor",
                "crc": "a6e8c3f7",
                "md5": "ec4569de0ba1339af82c0824732de2f0",
                "sha1": "2446562ad0a7ba6755ff48c5b4a4f3d530f01111",
                "rotation": "0",
                "avantx": "577",
                "avanty": "0",
                "avantw": "484",
                "avanth": "680",
                "cotex": "481",
                "cotey": "0",
                "cotew": "96",
                "coteh": "680",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(au)(gris)",
                "region": "au",
                "version": "gris",
                "crc": "67e65018",
                "md5": "a903d89656b44a0d11e698d97178f8f9",
                "sha1": "f5055e16afdc1b1004928e8e0d6dd41c17cbbc8a",
                "supportx": "97",
                "supporty": "8",
                "supportw": "409",
                "supporth": "339",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "supportx": "97",
                "supporty": "8",
                "supportw": "409",
                "supporth": "339",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(au)(gris)",
                "region": "nz",
                "version": "gris",
                "crc": "67e65018",
                "md5": "a903d89656b44a0d11e698d97178f8f9",
                "sha1": "f5055e16afdc1b1004928e8e0d6dd41c17cbbc8a",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(cus)(Sonic et Knuckles)",
                "region": "cus",
                "version": "Sonic et Knuckles",
                "crc": "5282e8be",
                "md5": "6cbc57ac7e07091b087756cf36a0863c",
                "sha1": "a2f13dc7f318770f79e00d18cc877aad47e3bfb6",
                "supportx": "14",
                "supporty": "112",
                "supportw": "571",
                "supporth": "55",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(cus)(accolade)",
                "region": "cus",
                "version": "accolade",
                "crc": "3d8d27a3",
                "md5": "35a77fa4aa3e3a725cd8850991a0bd36",
                "sha1": "e08c793e328b1e9faeae0701ae42e9d1de623af7",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(cus)(codemaster)",
                "region": "cus",
                "version": "codemaster",
                "crc": "74b7f386",
                "md5": "688d4ac5cff3d0a190deccba63a800de",
                "sha1": "9737b0d95835230c40148b910651f5bfcbdb04b2",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(cus)(codemaster-jcart)",
                "region": "cus",
                "version": "codemaster-jcart",
                "crc": "3509f415",
                "md5": "72e60691cb5145256ead486cc3a18f58",
                "sha1": "617a255de474e506d5e53e963b76c81a1dacb480",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(cus)(electronic art)",
                "region": "cus",
                "version": "electronic art",
                "crc": "7871c07b",
                "md5": "e3de384f9fdbdcb7e47c1fc7a870a23f",
                "sha1": "13fdf56e42849cdd19696b214fb82866ec437206",
                "supportx": "155",
                "supporty": "12",
                "supportw": "462",
                "supporth": "500",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(cus)(rouge)",
                "region": "cus",
                "version": "rouge",
                "crc": "fcdd9027",
                "md5": "9fce59b8bf390d2db6945ec29192ee70",
                "sha1": "29877f1d6735b3584d302c1e629103ea5301a64e",
                "supportx": "97",
                "supporty": "8",
                "supportw": "409",
                "supporth": "339",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(cus)(virtua-racing-grise)",
                "region": "cus",
                "version": "virtua-racing-grise",
                "crc": "eb550e90",
                "md5": "9c7c9360ceb979cee42ce570e455c950",
                "sha1": "31970be3eb56675153242898ce9f0858342abe2e",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(cus)(virtua-racing-noir)",
                "region": "cus",
                "version": "virtua-racing-noir",
                "crc": "f666984d",
                "md5": "b2b947076dea76769b8f96cf1a4c8f46",
                "sha1": "59159cb3bf9666b514fae452b356ffd484eabc43",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(jp)",
                "region": "jp",
                "version": "jp",
                "crc": "751f2b46",
                "md5": "a8d9e24c64691741bdfea5b0d51b22d8",
                "sha1": "48b3ab9a2cdf2fe193fc191852a605e1395813b8",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(jp)",
                "region": "kr",
                "version": "jp",
                "crc": "751f2b46",
                "md5": "a8d9e24c64691741bdfea5b0d51b22d8",
                "sha1": "48b3ab9a2cdf2fe193fc191852a605e1395813b8",
                "format": "png"
            },
            {
                "type": "support2D",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support2D(wor)",
                "region": "wor",
                "version": "wor",
                "crc": "b9842817",
                "md5": "9f997d1059ee34e717f397b8c91f2e19",
                "sha1": "affe61777a1650200b72bc189325ee99b377fe76",
                "format": "png"
            },
            {
                "type": "support-texture-gabarit",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support-texture-gabarit(jp)",
                "region": "jp",
                "crc": "85a516f5",
                "md5": "76c6dc63489f0585edce05a470af8754",
                "sha1": "e0b38b858738b8ccb236245f46a35841ea2b5043",
                "format": "png"
            },
            {
                "type": "support-texture-gabarit",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=support-texture-gabarit(wor)",
                "region": "wor",
                "crc": "f5147bb7",
                "md5": "ff8a4371612460aedec9bcda294b6603",
                "sha1": "d8a2b38a718eca865331b54c69e54617b297d662",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(BTN-A)",
                "version": "BTN-A",
                "crc": "d39ac1d2",
                "md5": "62ee885c4a4579d5650773d10dcbd497",
                "sha1": "d82e35a85e535bc4e0e4ecb4fb88497b639cccc8",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(BTN-B)",
                "version": "BTN-B",
                "crc": "5c35ed89",
                "md5": "d26f16b2af9bbc75234f47090f59aede",
                "sha1": "2005bb28c95df4c047c9a20e1471a63c5f18a6ce",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(BTN-C)",
                "version": "BTN-C",
                "crc": "45a27ab0",
                "md5": "08a12a3e85254a8c4382e83bea328609",
                "sha1": "9f0c455dd6f2c6574ddf3bcd9104d96ba01342ee",
                "rbctrlid": "A",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(BTN-START)",
                "version": "BTN-START",
                "crc": "8434a2ca",
                "md5": "8f275d2e680ab6d71a7e3ab7d443e9e5",
                "sha1": "34c7378a5751db688e19763ba5442474389d0d44",
                "rbctrlid": "START",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(BTN-X)",
                "version": "BTN-X",
                "crc": "9a02c341",
                "md5": "d662648c61f3d2b3fa7f436524935523",
                "sha1": "9978293aabe13000f4c0b6d3d79c387c0619d101",
                "rbctrlid": "L",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(BTN-Y)",
                "version": "BTN-Y",
                "crc": "68e5a231",
                "md5": "7bfba0025501aafa0aaf1c0fa9c50e22",
                "sha1": "248021668b2bad232920b4c0e3c156b0079ba924",
                "rbctrlid": "X",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(BTN-Z)",
                "version": "BTN-Z",
                "crc": "caeaddec",
                "md5": "35b1342983db1a31a3ffadebe407669c",
                "sha1": "2a0425f5844f342de5fd9e15d42ee05d4f67d450",
                "rbctrlid": "R",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(DOWN)",
                "version": "DOWN",
                "crc": "dbf79d38",
                "md5": "a67be3ea249ed92204601d0015a385fa",
                "sha1": "d7ff750ad2990b84126e53d703a9fa22175a61e4",
                "rbctrlid": "DOWN",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(LEFT)",
                "version": "LEFT",
                "crc": "eb4c2811",
                "md5": "c41e8450e453e133153670b2cd2f1a0a",
                "sha1": "959a48d307e419a92fcdd635382aed07a3367887",
                "rbctrlid": "LEFT",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(RIGHT)",
                "version": "RIGHT",
                "crc": "c695dc7f",
                "md5": "7838d7e992cde26c56cd2ebcf8106a64",
                "sha1": "8cdc0491d18f6fa05803d6b66f4dfb6d93d37d4e",
                "rbctrlid": "RIGHT",
                "format": "png"
            },
            {
                "type": "controls",
                "parent": "systeme",
                "url": "https:\/\/clone.screenscraper.fr\/api2\/mediaSysteme.php?devid=detain&amp;devpassword=UubH2awfx7l&amp;softname=ConSolo&amp;ssid=&amp;sspassword=&amp;systemeid=1&amp;media=controls(UP)",
                "version": "UP",
                "crc": "254deba1",
                "md5": "4c99c09fdbef941ae352a7b94240e147",
                "sha1": "2bf0900f198fc5b807bfb61b17193e3cfb3b7230",
                "rbctrlid": "UP",
                "format": "png"
            }
        ]
    },
*/

use Detain\ConSolo\Importing\ScreenScraper;

require_once __DIR__.'/../../../bootstrap.php';

if (in_array('-h', $_SERVER['argv']) || in_array('--help', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h, --help  this screen
    -f          force update even if already latest version
    --no-db     skip the db updates/inserts
    --no-cache  disables use of the file cache

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config;
global $queriesRemaining;
global $dataDir;
global $curl_config;
$curl_config = [];
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$usePrivate = false;
$useCache = !in_array('--no-cache', $_SERVER['argv']);;
$dataDir = __DIR__.'/../../../../data';
@mkdir($dataDir.'/json/screenscraper', 0775, true);
if (file_exists($dataDir.'/json/screenscraper/queries.json')) {
	$queriesRemaining = json_decode(file_Get_contents($dataDir.'/json/screenscraper/queries.json'), true);
} else {
	$queriesRemaining = ['yearmonth' => 0];
}
if (date('Ymd') > $queriesRemaining['yearmonth']) {
	$queriesRemaining['yearmonthday'] = date('Ymd');
	foreach ($config['ips'] as $ip) {
		$queriesRemaining[$ip] = 20000;
	}
}
if ($useCache == true && file_exists($dataDir.'/json/screenscraper/platforms.json')) {
	$platforms = json_decode(file_get_contents($dataDir.'/json/screenscraper/platforms.json'), true);
} else {
	$return = ScreenScraper::api('systemesListe');
	if ($return['code'] == 200) {
		//echo "Response:".print_r($return,true)."\n";
		$platforms = $return['response']['response']['systemes'];
		file_put_contents($dataDir.'/json/screenscraper/platforms.json', json_encode($platforms, getJsonOpts()));
		//print_r($platforms);
	}
}
$source = [
    'companies' => [],
    'platforms' => [],
    'emulators' => [
        'launchbox' => [
            'id' => 'launchbox',
            'name' => 'LaunchBox',
            'platforms' => [],
        ],
        'retropie' => [
            'id' => 'retropie',
            'name' => 'RetroPie',
            'platforms' => [],
        ],
        'recalbox' => [
            'id' => 'recalbox',
            'name' => 'RecalBox',
            'platforms' => [],
        ]
    ],
    'games' => []
];
foreach ($platforms as $idx => $platform) {
    $id = intval($platform['id']);
    if (isset($platform['noms']['noms_commun']) && trim($platform['noms']['noms_commun']) != '') {
        $altNames = explode(',', trim($platform['noms']['noms_commun']));
    } else {
        $altNames = [];
    }
    $name = false;
    foreach (['nom_us', 'nom_eu', 'nom_jp'] as $field) {
        if ($name === false && isset($platform['noms'][$field])) {
            $name = $platform['noms'][$field];
        } elseif (isset($platform['noms'][$field]) && !in_array($platform['noms'][$field], $altNames)) {
            $altNames[] = $platform['noms'][$field];
        }
    }
    $source['platforms'][$id] = [
        'id' => $id,
        'name' => $name,
        'altNames' => $altNames
    ];
    if (isset($platform['compagnie'])) {
        $source['platforms'][$id]['company'] = $platform['compagnie'];
        $source['companies'][$platform['compagnie']] = [
            'id' => $platform['compagnie'],
            'name' => $platform['compagnie'],
        ];
    }
    foreach (['launchbox', 'retropie', 'recalbox', 'hyperspin'] as $field) {
        if (isset($platform['noms']['nom_'.$field])) {
            $source['emulators'][$field]['platforms'][] = $id;
            if (!isset($source['platforms'][$platform['id']]['matches'])) {
                $source['platforms'][$id]['matches'] = [];
            }
            if (!isset($source['platforms'][$platform['id']]['matches'][$field])) {
                $source['platforms'][$id]['matches'][$field] = [];
            }
            $matches = explode(',', trim($platform['noms']['nom_'.$field]));
            foreach ($matches as $matchPlatId) {
                $source['platforms'][$id]['matches'][$field][] = $matchPlatId;
            }
        }
    }
}
$sources = json_decode(file_get_contents(__DIR__.'/../../../../../emurelation/sources.json'), true);
$sources['screenscraper']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
foreach ($source as $type => $data) {
    file_put_contents(__DIR__.'/../../../../../emurelation/'.$type.'/screenscraper.json', json_encode($data, getJsonOpts()));
}
if (!$skipDb) {
    echo "Mapping Platforms to db\n";
    $db->query('truncate ss_platforms');
    foreach ($platforms as $platform) {
	    $db->insert('ss_platforms')
	    ->cols(['doc' => json_encode($platform, getJsonOpts())])
	    ->query();
    }
}
