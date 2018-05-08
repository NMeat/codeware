#!/bin/bash
check_mount(){
    #cd /home/liuzhifeng01/www/ganji/ganji_online/fang/fangpc
    cd ~
    is_www_mount=$(mount | grep www);
    if [[ -z $is_www_mount ]];then
        echo 999
        cd ~
        sudo umount www
        sudo mount -t cifs //10.252.62.148/www ./www -o rw,dir_mode=0775,file_mode=0775,username=liu_share,password=755491,uid=liuzhifeng01,gid=work,nounix,sec=ntlmssp
    else
        echo 888
    fi
}

step=2
for (( i=0; i<60; i=(i+step) ));do
    check_mount
    sleep $step
done
exit 0;
