#################################################################
Tools to convert Japanese HTML CodeIgniter User Guide into Sphinx
#################################################################

******************
Setup Instructions
******************

There are tools to convert translated HTML CodeIgniter User Guide
into Sphinx RST files.

The tools are now under developping.

How to Use
==============

Get repoistoies.

::

	$ git clone git://github.com/EllisLab/CodeIgniter.git
	$ git clone git://github.com/codeigniter-jp/ci-ja.git
	$ git clone git://github.com/codeigniter-jp/html2sphinx.git

"ci-ja" repository has translated User Guide in "ci-ja/user_guide_ja/" folder.

Copy "CodeIgniter" repository's "user_guide_src/" folder as "user_guide_ja_src".

::

	$ cp -R CodeIgniter/user_guide_src ci-ja/user_guide_ja_src

Copy the tools to "source" folder.

::

	$ cp html2sphinx/* ci-ja/user_guide_ja_src/source/

Convert HTML into RST.

::

	$ cd ci-ja/user_guide_ja_src/source
	$ sh convert.sh

You can get Japanese RST files in "source" folder.
