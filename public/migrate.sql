drop table if exists meetings;
drop table if exists doctors;
drop table if exists messages;
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
    age integer not null default 0,
    diagnoses blob default 'Inga Diagnoser',
    bloodPreasure float default 0.0,
    spO2 float default 95.0,
    pulse float default 0.0,
    bloodGroup text default 'A+'
);

create table doctors
(
    doctorId integer primary key autoincrement not null,
    firstName text not null default 'Göran',
    lastName text not null default 'Göransson',
    age integer not null,
    personNr integer not null,
    emailAddress text not null,
    spec integer not null,
    nameAbbrev text not null,
    password text not null,
    isAdmin integer not null default 0,
    loggedIn integer not null default 0,
    foreign key (spec) references specialisations(specId)
);

create table bloodGroup
(
    id integer primary key autoincrement not null,
    date text not null,
    bloodGroup text not null default 'A+',
    patientId integer not null,
    foreign key (patientId) references patients(patientId)
);

-- TODO Tabeller för resterande vitala parametrar

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
    date text not null default ' ',
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
           'Underskörtersa',
           'uska'
       );

insert into patients(firstName, lastName, personNr, age, diagnoses, bloodPreasure, spO2, pulse, bloodGroup)
values ('Göran', 'Antersson', 192003041337, 102, 'Inga Diagnoser', 23.6, 86.9, 40.1, 'B-');

insert into doctors(firstName, lastName, age, personNr, emailAddress, spec, nameAbbrev, password)
values
    (
        'Nils',
        'Nilsson',
        30,
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
(firstName, lastName, age, personNr, emailAddress, spec, nameAbbrev, password, isAdmin)
values ('Anton', 'Norman', 18, 200304070000, 'normananton03@gmail.com', 2, 'antnor', 'f29444ed56b0ffeeadc2908a172e92f1', 1);

insert into doctors
(firstName, lastName, age, personNr, emailAddress, spec, nameAbbrev, password, isAdmin)
values ('Elvira', 'Ling', 19, 200301080000, 'elviraling77@gmail.com', 2, 'elvlin', '85855b2978bd7857121527196cac2d9f', 1);

insert into
    doctors(firstName, lastName, age, personNr, emailAddress, spec, nameAbbrev, password, isAdmin)
values ('Vilgot','Kihlberg',18,200303250000,'vilgot.kihlberg@gmail.com', 2,'vilkih','50e930c4b066caaa769f07318ff81a37',1);

