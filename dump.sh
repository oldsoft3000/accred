#!/bin/bash


mysqldump -u root -p818181 --add-drop-table --databases accred > dump.sql
