#! /bin/bash

#this bash script will take (old_name, new_name) format csv, format it correctly, then execute the bash script to change the names)
# -v instructs mv to shou what it is doing with the data in case something goes wrong, you'll be able to see what happened
# -i asks if it will overwrite existing files
sed 's/^/mv -vi "/;s/, /" "/;s/$/";/' < names.csv | bash -

#this is the Google Cloud Storage recommended script for renaming single files
gcloud storage mv gs://BUCKET_NAME/OLD_OBJECT_NAME gs://BUCKET_NAME/NEW_OBJECT_NAME