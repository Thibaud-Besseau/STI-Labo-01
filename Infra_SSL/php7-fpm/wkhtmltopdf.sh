xvfb-run -a -s "-screen 0 640x480x16" wkhtmltopdf --dpi 150 --zoom 0.6 "$@" 
