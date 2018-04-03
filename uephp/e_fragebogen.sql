use fragebogen;


INSERT INTO `kategorien` (`KategorieID`, `Bezeichnung`) VALUES
(1, '1. Weltkrieg'),
(2, 'Panzer'),
(3, 'Politik');

insert into fragen (`FragenID`, `FK_Kategorie`, `Frage`) values 
(1, 1, 'Wer wollte der neue Dschngis Khan werden?'),
(2, 1, 'Wer hat das Maschinengewehr verbreitet?'),
(3, 2, 'Was ist der Hauptpanzer Frankreichs?'),
(4, 2, 'Welcher Panzer hatte den ersten drehbaren Geschützturm?'),
(5, 3, 'Wer gewinnt die nächste russiche Präsidentschaftswahl?'),
(6, 3, 'Ist das UK ein Witz?');

insert into antworten (`AntwortID`, `FK_FragenID`, `Text`) values 
(1, 1, 'Baron von Ungarn Sternberg'),
(2, 1, 'Kaiser Franz Josef'),
(3, 1, 'Lionel Dunsterville'),
(4, 2, 'Hiram Maxim'),
(5, 2, 'Conrad von Hötzendorf'),
(6, 2, 'Andrew Garfield'),
(7, 3, 'Leclerc'),
(8, 3, 'Leopard 2'),
(9, 3, 'T90'),
(10, 4, 'FT-17'),
(11, 4, 'Mark I'),
(12, 4, 'Mark IV'),
(13, 5, 'Putin'),
(14, 5, 'Trump'),
(15, 5, 'Merkel'),
(16, 6, 'JA'),
(17, 6, 'Nein'),
(18, 6, 'Vielleicht');
;

insert into is_richtig (`is_richtig_id`, `FK_anworten`, `richtig`) values 
(1, 1, true),
(2, 2, false),
(3, 3, false),
(4, 4, true),
(5, 5, false),
(6, 6, false),
(7, 7, true),
(8, 8, false),
(9, 9, false),
(10, 10, true),
(11, 11, false),
(12, 12, false),
(13, 13, true),
(14, 14, false),
(15, 15, false),
(16, 16, true),
(17, 17, false),
(18, 18, false);