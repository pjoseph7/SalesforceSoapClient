CREATE TABLE SMARTS.WGBSFTS
(
  WGBSFTS_SFID              varchar2(100),
  WGBSFTS_firstName         varchar2(40),
  WGBSFTS_lastName          varchar2(40),
  WGBSFTS_title             varchar2(80),
  WGBSFTS_department        varchar2(80),
  WGBSFTS_dob               varchar2(10),
  WGBSFTS_phone             varchar2(20),
  WGBSFTS_email             varchar2(120)
  
  
)
TABLESPACE DEVELOPMENT
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          80K
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
           )
LOGGING 
NOCOMPRESS 
NOCACHE
NOPARALLEL
MONITORING;


ALTER TABLE SMARTS.WGBSFTS ADD (
  CONSTRAINT PK_WGBSFTS
PRIMARY KEY
(WGBSFTS_SFID)
    USING INDEX 
    TABLESPACE DEVELOPMENT_INDEXES
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          80K
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
               ));


insert into  SMARTS.WGBSFTS (wgbsfts_sfid, WGBSFTS_firstName, WGBSFTS_lastName, WGBSFTS_title, WGBSFTS_department, WGBSFTS_dob, WGBSFTS_phone, WGBSFTS_email) values('003o000000BIri1AAD', 'Tim', 'Barr', 'King', 'Finance', '1948-05-18', '(812) 332-5000', 'barr_tim@grandhotels.com');

insert into  SMARTS.WGBSFTS (wgbsfts_sfid, WGBSFTS_firstName, WGBSFTS_lastName, WGBSFTS_title, WGBSFTS_department, WGBSFTS_dob, WGBSFTS_phone, WGBSFTS_email) values('003o000000BIri2AAD', 'John', 'Bond', 'VP, Facilities', 'Facilities', '1950-07-30', '(312) 596-1000', 'bond_john@grandhotels.com');

insert into  SMARTS.WGBSFTS (wgbsfts_sfid, WGBSFTS_firstName, WGBSFTS_lastName, WGBSFTS_title, WGBSFTS_department, WGBSFTS_dob, WGBSFTS_phone, WGBSFTS_email) values('003o000000BIri4AAD', 'Lauren', 'Boyle', 'SVP, Technology', 'Technology', '1955-02-26', '(212) 842-5500', 'lboyle@uog.com');

insert into  SMARTS.WGBSFTS (wgbsfts_sfid, WGBSFTS_firstName, WGBSFTS_lastName, WGBSFTS_title, WGBSFTS_department, WGBSFTS_dob, WGBSFTS_phone, WGBSFTS_email) values('003o000000BIrhxAAD', 'Sean', 'Forbes', 'CFO', 'Finance', '1941-06-20', '(512) 757-6000', 'sean@edge.com');


insert into  SMARTS.WGBSFTS (wgbsfts_sfid, WGBSFTS_firstName, WGBSFTS_lastName, WGBSFTS_title, WGBSFTS_department, WGBSFTS_dob, WGBSFTS_phone, WGBSFTS_email) values('003o000000BIriCAAT', 'Edna', 'Frank', 'VP, Technology', 'Technology', '1936-12-02', '(650) 867-3450', 'efrank@genepoint.com');

insert into  SMARTS.WGBSFTS (wgbsfts_sfid, WGBSFTS_firstName, WGBSFTS_lastName, WGBSFTS_title, WGBSFTS_department, WGBSFTS_dob, WGBSFTS_phone, WGBSFTS_email) values('004o000000BIri3AAD', 'Stella', 'Pavlova', 'SVP, Production', 'Production', '1938-01-13', '(212) 842-5500', 'spavlova@uog.com');







commit;
select * from wgbsfts;

