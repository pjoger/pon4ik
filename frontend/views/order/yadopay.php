<?php

/*
 * Copyright (C) 2016 pj
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

//vd([$response, $rrr]);
$date = new DateTime();
echo '<?xml version="1.0" encoding="UTF-8"?>'
            . '<' . $response['action'] . 'Response performedDatetime="' . $date->format('Y-m-d H:i:s')
              . '" code="' . $response['code']
              . '" ' . ($response['msg'] != null ? 'message="' . $response['msg'] . '"' : "")
              . ' invoiceId="' . $response['invoiceId']
              . '" shopId="' . $response['shopId']
            . '"/>';