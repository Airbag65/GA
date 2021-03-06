drop table if exists meetings;
drop table if exists doctors;
drop table if exists messages;
drop table if exists bloodGroup;
drop table if exists syresättning;
drop table if exists puls;
drop table if exists blodtryck;
drop table if exists patients;
drop table if exists specialisations;
drop table if exists ICD10;

pragma foreign_keys = on;


create table specialisations
(
    specId integer primary key autoincrement not null,
    specName text not null,
    specAcro text not null
);
create table patients
(
    patientId integer primary key autoincrement not null,
    firstName text not null default 'Greger',
    lastName text not null default 'Grön',
    personNr integer not null,
    diagnoses blob default 'Inga Diagnoser',
    bloodPreasure float default 0.0,
    spO2 float default 95.0,
    pulse float default 0.0,
    bloodGroup text default 'Okänd'
);

create table doctors
(
    doctorId integer primary key autoincrement not null,
    firstName text not null default 'Göran',
    lastName text not null default 'Göransson',
    personNr integer not null,
    emailAddress text not null,
    spec integer not null,
    nameAbbrev text not null,
    password text not null,
    isAdmin integer not null default 0,
    foreign key (spec) references specialisations(specId)
);

create table bloodGroup
(
    id integer primary key autoincrement not null,
    date text default CURRENT_TIMESTAMP,
    bloodGroup text not null default 'Okänd',
    patientId integer not null,
    foreign key (patientId) references patients(patientId)
);

create table syresättning
(
    id integer primary key autoincrement not null,
    date text default CURRENT_TIMESTAMP,
    syresattning float not null default 0.0,
    patientId integer not null,
    foreign key (patientId) references patients(patientId)
);

create table puls
(
    id integer primary key autoincrement not null,
    date text default CURRENT_TIMESTAMP,
    puls float not null default 0.0,
    patientId integer not null,
    foreign key (patientId) references patients(patientId)
);

create table blodtryck
(
    id integer primary key autoincrement not null,
    date text default CURRENT_TIMESTAMP,
    blodtryck float not null default 0.0,
    patientId integer not null,
    foreign key (patientId) references patients(patientId)
);


create table messages
(
    messageId integer primary key autoincrement not null,
    patientId integer not null,
    doctorId integer not null,
    message text not null default ' ',
    date text not null default ' ',
    foreign key (doctorId) references doctors (doctorId),
    foreign key (patientId) references patients (patientId)
);

create table meetings
(
    meetingId integer primary key autoincrement not null ,
    doctorId integer not null,
    patientId integer not null,
    diagnosis text not null default 'Ingen Diagnos',
    comment text default ' ',
    blodtryck text default null,
    puls text default null,
    mattnad text default null,
    date timestamp not null default CURRENT_TIMESTAMP,
    foreign key (doctorId) references doctors (doctorId),
    foreign key (patientId) references patients (patientId)
);

create table ICD10(
                      id integer primary key autoincrement not null,
                      abbreviation text,
                      expansion text
);


insert into specialisations(specName, specAcro)
values (
           'Underskörterska',
           'uska'
       );

insert into patients(firstName, lastName, personNr, diagnoses, bloodPreasure, spO2, pulse, bloodGroup)
values ('Göran', 'Antersson', 192003041337, 'DÖD', 23.6, 86.9, 40.1, 'B-');

insert into doctors(firstName, lastName, personNr, emailAddress, spec, nameAbbrev, password)
values
    (
        'Nils',
        'Nilsson',
        199201012299,
        'nils.nilsson@nilsmail.com',
        1,
        'nilnil',
        'd970019ea54182a6259b47409af28de2'
    );


insert into meetings(doctorId, patientId, diagnosis, comment)
values (
           1,
           1,
           'död',
           'Patienten har avlidit'
       );


insert into
    specialisations(specName, specAcro)
values ('Administratör', 'admin'),
       ('Läkare', 'laka'),
       ('Kirurg', 'kiru'),
       ('Ortoped', 'orto'),
       ('Optiker', 'opti');

insert into doctors
(firstName, lastName, personNr, emailAddress, spec, nameAbbrev, password, isAdmin)
values ('Anton', 'Norman', 200304070000, 'normananton03@gmail.com', 2, 'antnor', 'db63c7e38ee64bdd02601002fb27eff5', 1);

insert into doctors
(firstName, lastName, personNr, emailAddress, spec, nameAbbrev, password, isAdmin)
values ('Elvira', 'Ling', 200301080000, 'elviraling77@gmail.com', 2, 'elvlin', '85855b2978bd7857121527196cac2d9f', 1);

insert into
    doctors(firstName, lastName, personNr, emailAddress, spec, nameAbbrev, password, isAdmin)
values ('Vilgot','Kihlberg',200303250000,'vilgot.kihlberg@gmail.com', 2,'vilkih','50e930c4b066caaa769f07318ff81a37',1);

insert into
    doctors(firstName, lastName, personNr, emailAddress, spec, nameAbbrev, password, isAdmin)
values ('Axel', 'Genar', 200310130000, 'axel.genar@gmail.com', 5, 'axegen', '561785a33a9c5cc86ba1176df052e995', 0);

insert into
    patients(firstName, lastName, personNr, bloodPreasure, spO2, pulse, bloodGroup)
values ('Bengt', 'Wallgren', 200301010000, 0.0, 95.0, 99.0, 'Okänd');