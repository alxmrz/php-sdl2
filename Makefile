headers:
	gcc -D "aligned(ARGS)" -D "__align__(ARGS)" -D "__attribute__(ARGS)" -E /usr/include/SDL2/SDL.h -o SDL.h
dw:
	php examples/display_window.php
dt:
	php examples/display_text.php
he:
	php examples/handle_events.php
di:
	php examples/display_image.php
pa:
	php examples/play_audio.php
test:
	./vendor/bin/phpunit --colors tests