headers:
	gcc -D "aligned(ARGS)" -D "__align__(ARGS)" -D "__attribute__(ARGS)" -E /usr/include/SDL2/SDL.h -o SDL.h
sw:
	php examples/display_window.php
dt:
	php examples/display_text.php
eh:
	php examples/handle_events.php
test:
	./vendor/bin/phpunit --colors tests