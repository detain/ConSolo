
all: mame

mame:
	cd src/Importing/Program/MAME && php update.php
