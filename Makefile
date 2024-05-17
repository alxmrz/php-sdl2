headers:
	gcc -D "aligned(ARGS)" -D "__align__(ARGS)" -D "__attribute__(ARGS)" -E /usr/include/SDL2/SDL.h -o SDL.h
sw:
	php examples/simple_window.php
test:
	./vendor/bin/phpunit --colors tests