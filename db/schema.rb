# This file is autogenerated. Instead of editing this file, please use the
# migrations feature of ActiveRecord to incrementally modify your database, and
# then regenerate this schema definition.

ActiveRecord::Schema.define() do

  create_table "articles", :force => true do |t|
    t.column "title",      :string,    :limit => 150, :default => "",    :null => false
    t.column "tags",       :string,    :limit => 200
    t.column "author_id",  :integer,                                     :null => false
    t.column "body",       :text,                     :default => "",    :null => false
    t.column "created_at", :datetime,                                    :null => false
    t.column "updated_at", :timestamp,                                   :null => false
    t.column "published",  :boolean,                  :default => false, :null => false
  end

  add_index "articles", ["author_id"], :name => "author_id"
  add_index "articles", ["published"], :name => "published"
  add_index "articles", ["title"], :name => "title"
#  add_index "articles", ["body"], :name => "body"

  create_table "events", :force => true do |t|
    t.column "title",       :string,    :limit => 150, :default => "", :null => false
    t.column "agenda",      :text,                     :default => "", :null => false
    t.column "description", :text,                     :default => "", :null => false
    t.column "minute_id",   :integer
    t.column "venue_id",    :integer
    t.column "date",        :datetime
    t.column "speaker_id",  :integer
    t.column "published",   :integer,   :limit => 4,   :default => 0,  :null => false
    t.column "created_at",  :timestamp,                                :null => false
  end

  add_index "events", ["minute_id"], :name => "minute_id"
  add_index "events", ["venue_id"], :name => "venue_id"
  add_index "events", ["speaker_id"], :name => "speaker_id"
  add_index "events", ["published"], :name => "published"
#  add_index "events", ["description"], :name => "description"
#  add_index "events", ["agenda"], :name => "agenda"
  add_index "events", ["title"], :name => "title"

  create_table "minutes", :force => true do |t|
    t.column "event_id",   :integer,                                :null => false
    t.column "author_id",  :integer,                                :null => false
    t.column "body",       :text,                   :default => "", :null => false
    t.column "published",  :integer,   :limit => 4, :default => 0,  :null => false
    t.column "created_at", :timestamp,                              :null => false
  end

  add_index "minutes", ["event_id"], :name => "event_id"
  add_index "minutes", ["author_id"], :name => "author_id"
  add_index "minutes", ["published"], :name => "published"
#  add_index "minutes", ["body"], :name => "body"

  create_table "pages", :force => true do |t|
    t.column "title",      :string,    :limit => 30, :default => "", :null => false
    t.column "body",       :text,                    :default => "", :null => false
    t.column "author_id",  :integer,                                 :null => false
    t.column "order",      :integer,   :limit => 4
    t.column "published",  :integer,   :limit => 4,  :default => 0,  :null => false
    t.column "created_at", :timestamp,                               :null => false
  end

  add_index "pages", ["title"], :name => "title"
  add_index "pages", ["author_id"], :name => "author_id"
  add_index "pages", ["order"], :name => "order"
  add_index "pages", ["published"], :name => "published"

  create_table "people", :force => true do |t|
    t.column "username",   :string,    :limit => 50,  :default => "", :null => false
    t.column "password",   :string,    :limit => 45,  :default => "", :null => false
    t.column "fullname",   :string,    :limit => 100, :default => "", :null => false
    t.column "nickname",   :string,    :limit => 50
    t.column "irc_nick",   :string,    :limit => 30
    t.column "email",      :string,    :limit => 100, :default => "", :null => false
    t.column "webpage",    :string,    :limit => 100
    t.column "visible",    :integer,   :limit => 4,   :default => 0,  :null => false
    t.column "deleted",    :integer,   :limit => 4,   :default => 0,  :null => false
    t.column "created_at", :timestamp,                                :null => false
  end

  add_index "people", ["username"], :name => "username_2", :unique => true
  add_index "people", ["email"], :name => "email_2", :unique => true
  add_index "people", ["username"], :name => "username"
  add_index "people", ["password"], :name => "password"
  add_index "people", ["fullname"], :name => "fullname"
  add_index "people", ["nickname"], :name => "nickname"
  add_index "people", ["email"], :name => "email"
  add_index "people", ["visible"], :name => "visible"
  add_index "people", ["deleted"], :name => "deleted"

  create_table "settings", :force => true do |t|
    t.column "key",   :string, :limit => 50,  :default => "", :null => false
    t.column "value", :string, :limit => 200
  end

  add_index "settings", ["key"], :name => "key"

  create_table "venues", :force => true do |t|
    t.column "short_name",     :string,    :limit => 50,  :default => "", :null => false
    t.column "name",           :string,    :limit => 150, :default => "", :null => false
    t.column "organization",   :string,    :limit => 150, :default => "", :null => false
    t.column "locality",       :string,    :limit => 50,  :default => "", :null => false
    t.column "address",        :string,    :limit => 200, :default => "", :null => false
    t.column "reaching",       :text
    t.column "venue_url",      :string,    :limit => 200
    t.column "contact_person", :string,    :limit => 30
    t.column "contact_phone",  :string,    :limit => 11
    t.column "published",      :integer,   :limit => 4,   :default => 0,  :null => false
    t.column "created_at",     :timestamp,                                :null => false
  end

  add_index "venues", ["address"], :name => "address"
  add_index "venues", ["published"], :name => "published"

end
