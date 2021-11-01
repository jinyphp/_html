<?php

        /*
        echo $table->setThead(
            ['Database'=>"데이터베이스"]
        )->build();
        */
        
        $table->setThead(
            ['Database'=>"데이터베이스"]
        );
        $table->setHref('Database', "Database");
        echo $table->build();

        /*
        $table->setThead(
            ['Database'=>"데이터베이스"]
        );
        $table->setHref('Database', ['field'=>"Database", 'url'=>"schemas"]);
        echo $table->build();
        */