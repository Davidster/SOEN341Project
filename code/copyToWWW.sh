scp -r ./ $1@login.encs.concordia.ca:/www/home/"$(echo $1 | head -c 1)"/$1/ &&
ssh $1@login.encs.concordia.ca chmod -R 755 /www/home/"$(echo $1 | head -c 1)"/$1/