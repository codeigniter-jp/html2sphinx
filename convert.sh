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
	general/requirements
	installation/index
	general/index
	libraries/index
	helpers/index
	database/index
	documentation/index
	tutorial/index
	general/quick_reference
	general/credits
EOD

