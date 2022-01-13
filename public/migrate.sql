drop table if exists doctors;
drop table if exists meetings;
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
    diagnoses blob default 'Inga Diagnoser'
);

create table doctors
(
    doctorId integer primary key autoincrement not null,
    firstName text not null default 'Göran',
    lastName text not null default 'Göransson',
    emailAddress text not null,
    spec integer not null,
    nameAbreiv text not null,
    password text not null,
    loggedIn integer not null default 0,
    foreign key (spec) references specialisations(specId)
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

insert into patients(firstName, lastName, personNr, age)
values('Anders', 'Andersson', 20000000, 50);

insert into doctors(firstName, lastName, emailAddress, spec, nameAbreiv, password)
values
    (
        'Nils',
        'Nilsson',
        'nils.nilsson@nilsmail.com',
        1,
        'nilnil',
        'gibberish'
    );


insert into meetings(doctorId, patientId, diagnosis, comment)
values (
           1,
           1,
           'död',
           'Patienten har avlidit'
       );

insert into doctors
(firstName, lastName, emailAddress, spec, nameAbreiv, password)
values ('Anton', 'Norman', 'normananton03@gmail.com', 1, 'antnor', 'heje');

insert into doctors
(firstName, lastName, emailAddress, spec, nameAbreiv, password)
values ('Elvira', 'Ling', 'elviraling77@gmail.com', 1, 'elvlin', 'kekw4');

