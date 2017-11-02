mPDF is a PHP class which generates PDF files from UTF-8 encoded HTML. It is based on [FPDF](http://www.fpdf.org/)
and [HTML2FPDF](http://html2fpdf.sourceforge.net/) (see [CREDITS](CREDITS.txt)), with a number of enhancements.
mPDF was written by Ian Back and is released under the [GNU GPL v2 licence](LICENSE.txt).

This version of mPDF has been  for use with [Gravity PDF](https://gravitypdf.com). Changes include:

* WordPress filters added
* WP_DEBUG support added
* All depreciated errors are converted to notices
* Reduce package size by removing some of the larger fonts, including the CJK font support.
* Better configuration defaults
* Additional Bug Fixes
* Removal of some features, including: progress bar

We recommend you use the [vanilla Mpdf package](https://github.com/mpdf/mpdf/).  
