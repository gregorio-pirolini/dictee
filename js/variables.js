const aKeys=[
    // 0            1           2           3            4              5               6
    ['ARRÊT',   'ARRÊT',    'red',          '',         '',             'befehl',       ''],
    ['DÉPART',  'DÉPART',   'red',          '',         '',             'befehl',    'depart'],
    ['↩',       'REJOUE',   'red',         '',          'REJOUE',       'befehl',   ''],
    ['"',       'RÉPÈTE',   'red',          '',         'RÉPÈTE',       'befehl', ''],
    ['♣',       'AIDE',     'red',          '',        'AIDE',         'befehl', ''],
    ['?',       'MYSTÈRE',  'red',          '',         'MYSTÈRE',      'befehl', ''],
    ['MARCHE',  'MARCHE',   'red',          '',         'ÉPELLE',       'befehl', ''],
    ['a',       '65',       'yellow',       '',         '',             'letter', ''],
    ['b',       '66',       'orange',       '',         '',             'letter', ''],
    ['c',       '67',       'orange',       '',         '',             'letter', ''],
    ['d',       '68',       'orange',       '',         '',             'letter', ''],
    ['e',       '69',       'yellow',       '',         '',             'letter', ''],
    ['f',       '70',       'orange',       '',         '',             'letter', ''],
    ['g',       '71',       'orange',       '',         '',             'letter', ''],
    ['h',       '72',       'orange',       '',         '',             'letter', ''],
    ['i',       '73',       'yellow',       '',         '',             'letter', ''],
    ['j',       '74',       'orange',       '',         '',             'letter', ''],
    ['k',       '75',       'orange',       '',         '',             'letter', ''],
    ['l',       '76',       'orange',       '',         '',             'letter', ''],
    ['m',       '77',       'orange',       '',         '',             'letter', ''],
    ['n',       '78',       'orange',       '',         '',             'letter', ''],
    ['o',       '79',       'yellow',       '',         '',             'letter', ''],
    ['p',       '80',       'orange',       '',         '',             'letter', ''],
    ['q',       '81',       'orange',       '',         '',             'letter', ''],
    ['r',       '82',       'orange',       '',         '',             'letter', ''],
    ['s',       '83',       'orange',       '',         '',             'letter', ''],
    ['t',       '84',       'orange',       '',         '',             'letter', ''],
    ['u',       '85',       'yellow',       '',         '',             'letter', ''],
    ['v',       '86',       'orange',       '',         '',             'letter', ''],
    ['w',       '87',       'orange',       '',         '',             'letter', ''],
    ['x',       '88',       'orange',       '',         '',             'letter', ''],
    ['y',       '89',       'yellow',       '',         '',             'letter', ''],
    ['z',       '90',       'orange',       '',         '',             'letter', ''],
    ['à',       '224',      'yellow',       '',         '',             'letter', ''],
    ['â',       '226',      'yellow',       '',         '',             'letter', ''],
    ['ç',       '231',      'orange',       '',         '',             'letter', ''],
    ['ë',       '235',      'yellow',       '',         '',             'letter', ''],
    ['é',       '233 0232', 'yellow',       '',         '',             'letter', ''],
    ['è',       '232',      'yellow',       '',         '',             'letter', ''],
    ['ê',       '234',      'yellow',       '',         '',             'letter', ''],
    ['î',       '238',      'yellow',       '',         '',             'letter', ''],
    ['ï',       '239',      'yellow',       '',         '',             'letter', ''],
    ['ô',       '244',      'yellow',       '',         '',             'letter', ''],
    ['œ',       '339',      'yellow',       '',         '',             'letter', ''],
    ['û',       '251',      'yellow',       '',         '',             'letter', ''],
    ['ù',       '249',      'yellow',       '',         '',             'letter', ''],
    ['ü',       '252',      'yellow',       '',         '',             'letter', ''],
    ['-',       '45',       'lightpink',    '',         '',             'letter', ''],
    ["'",       '39',       'lightpink',    '',         '',            'letter', ''],
    ['⇧',       '16',       'lightblue',    'MAJUSCULE','',             'befehl', ''],
    ['←',       '8',        'red',          'EFFACE',   '',             'befehl', ''],
    ['↲',       '13',       'red',          'ESSAYE',   '',             'befehl']
    
];

const aBien=[
['bien','ordres/bien'],
['bonneReponse','ordres/bien'],
['cEstCorrect','ordres/bien'],
['cEstExact','ordres/bien'],
['laReponseEstBonne','ordres/bien'],
['oui','ordres/bien'],
['super','ordres/bien'],
['tresBien','ordres/bien']
];

const aFaux=[
['cEstInexacte','ordres/faux'],
['cEstIncorect','ordres/faux'],
['non','ordres/faux'],
['sefo','ordres/faux']
];

const aRecommence=[
['recommence','ordres/recommence'],
['encoreUneFois','ordres/recommence'],
['essayeEncoreUneFois','ordres/recommence'],
['essayeEncore','ordres/recommence'] 
];

const aEpelleCourt=[
['ecrit','ordres/epelleCourt'],
['epelle','ordres/epelleCourt'],
['ortografi','ordres/epelleCourt'],
['tapeLeMot','ordres/epelleCourt'],
['commentSEcrit','ordres/epelleLong']
];

const aEpelleLong=[
['commentEpelTu','ordres/epelleLong'],
['commentSEcrit','ordres/epelleLong'],
['maintenantEpele','ordres/epelleLong'],
['commentEcritue','ordres/epelleLong'],
['epelleEnsuite','ordres/epelleLong']
];
const aCorrection=[
[['leMot','sEcrit'],'ordres/correction'],
[['lOrthographeDuMot','est'],'ordres/correction'],
[['leMot','sEcrit'],'ordres/correction'],
[['onEcritLeMot',''],'ordres/correction'],
[['laBonneOrthographeDuMot','est'],'ordres/correction'],
[['','sEcrit'],'ordres/correction']
];

const aSound=[
    'MELODY1','MELODY2','MELODY3','MELODY4'
];





