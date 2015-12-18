<?php

namespace kcfinder;

chdir("..");
require "core/autoload.php";
$min = new minifier("css");
$min->minify("cache/base.css");
