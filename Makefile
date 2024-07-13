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
hme:
	php examples/handle_mouse_events.php
ir:
	php examples/image_rotation.php
dp:
	php examples/draw_point.php
wptt:
	php examples/write_pixels_to_texture.php
test:
	./vendor/bin/phpunit --colors tests