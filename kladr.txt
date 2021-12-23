# How to convert KLADR to CSV then to MYSQL and then to CT

## Ubuntu 20.x instruction


    in the [mysqld] section add this line:

local_infile    = 1

    add to the bottom of the file these two lines:

[client]

local_infile    = 1
