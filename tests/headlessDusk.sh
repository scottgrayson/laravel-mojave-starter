#!/bin/bash
pids=$(pidof /usr/bin/Xvfb)

if [ ! -n "$pids" ]; then
 Xvfb :0 -screen 0 1280x960x24 &
fi

php artisan dusk "$@"
