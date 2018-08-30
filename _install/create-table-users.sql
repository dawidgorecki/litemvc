create table if not exists public.users
(
  id                       serial                           not null,
  username                 text                             not null,
  email                    text                             not null,
  password_hash            text                             not null,
  first_name               text,
  last_name                text,
  role                     smallint default '1' :: smallint not null,
  is_active                boolean default true             not null,
  last_login               timestamp,
  last_failed_login        timestamp,
  failed_login_count       smallint default '0' :: smallint not null,
  activation_hash          text,
  password_reset_hash      text,
  password_reset_timestamp timestamp,
  created_at               timestamp default now()          not null,
  created_by               text                             not null,
  modified_at              timestamp,
  modified_by              text,

  constraint users_pkey
  primary key (id),
  constraint users_name_key
  unique (username),
  constraint users_email_key
  unique (email)
);

-- default username: admin
-- default password: admin

insert into public.users (username, email, password_hash, created_by)
values ('admin', 'admin@domain.com', '$2y$10$a9c09TuhRcO6MVDnnHD7herFRfEyxCcKsRaa6Y4ZV/528xeoPxEXu', 'system');