#!/bin/bash

# ftp_user=`cat /mnt/test | grep user: | awk 'gsub("user:","",$NF) {print $NF}'`
# ftp_passwd=`cat /mnt/test |grep passwd: | awk 'gsub("passwd:","",$NF) {print $NF}'`
lftp_action="$1"
ftp_user="$2"
ftp_passwd="$3"
ftp_site="$4"
ftp_port="$5"

# echo "$ftp_user, $ftp_passwd, $lftp_action"

if [ "$lftp_action"  = "login_check" ];then
    sh_result="$6"
    # ftp_site=`cat /mnt/test | grep site: | awk 'gsub("site:","",$NF) {print $NF}'`
    # echo "$ftp_site"
    if [ -n "$ftp_site" ]; then
        lftp "$ftp_user":"$ftp_passwd"@"$ftp_site":"$ftp_port" << EOF
        set ftp:passive-mode 0
        set net:timeout 1
        set net:max-retries 2
        set net:reconnect-interval-base 10
        set net:reconnect-interval-multiplier 2
        ls>"$sh_result"
        close
        bye
EOF

        if [ ! -e "$sh_result" ]; then
            echo "login incorrect"
        fi
        else
            echo "no server address"
    fi

fi

if [ "$lftp_action" = "upload" ]; then
    # ftp_site=`cat /mnt/test | grep site: | awk 'gsub("site:","",$NF) {print $NF}'`
    # echo "$ftp_site"
    if [ -n "$ftp_site" ]; then
        tmp_path="/tmp/"
        report_path="/mnt1/reports/"
        upload_file="$6"
        del_local_file="$7"
        tar_name="$8"

        if [ "$del_local_file" = "true" ]; then
            mv $report_path$upload_file $tmp_path$upload_file
            put_local_file=-E
        else
            cp $report_path$upload_file $tmp_path$upload_file
            put_local_file=
        fi

        tar -zcvf $tmp_path$tar_name $tmp_path$upload_file

        lftp "$ftp_user":"$ftp_passwd"@"$ftp_site":"$ftp_port" << EOF
        set ftp:passive-mode 0
        set net:timeout 1
        set net:max-retries 2
        set net:reconnect-interval-base 10
        set net:reconnect-interval-multiplier 2
        put $put_local_file $tmp_path$tar_name

        close
        bye
EOF
        rm $tmp_path$tar_name $tmp_path$upload_file
        echo "upload file ok"
    fi
fi



