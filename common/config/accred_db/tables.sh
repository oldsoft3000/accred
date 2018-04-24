#!/bin/bash

mysql -u root -p$1 < hotel.sql
mysql -u root -p$1 < flight.sql
mysql -u root -p$1 < ticket.sql
mysql -u root -p$1 < car.sql
mysql -u root -p$1 < particip.sql
mysql -u root -p$1 < user.sql

