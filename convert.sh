#!/bin/sh

for i in `cat FILES`; do
  file=`echo $i | sed -e "s/\.rst$//"`
  file="../../user_guide_ja/$file.html"
  if [ ! -f $file ]; then
    continue
  fi

  ls $file
  python html2rest.py $file > $i
  php filter.php $i
done

cat << EOD >> index.rst 
.. toctree::
	:glob:
	:titlesonly:
	:hidden:
	
	*
	overview/index
	installation/index
	general/index
	libraries/index
	database/index
	helpers/index
	documentation/index
EOD

