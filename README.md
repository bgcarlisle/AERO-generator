AERO generator v. 1.1
==============

## Overview

The AERO generator is a free web-based application for generating AERO diagrams from spreadsheet data using the tikz package for LaTeX. The AERO (Accumulating Evidence and Research Organization) diagram is based on Spencer Hey's paper (Hey et al. Trials 2013, 14:159[^1]) and the application was first developed in May 2014 by Benjamin Carlisle and Andrew Chung, members of the STREAM research group[^2] in the Biomedical Ethics Unit at McGill University. It is released as free and open-source under the GNU GPL v 2.

[^1]: <http://www.trialsjournal.com/content/14/1/159>
[^2]: <http://www.translationalethics.com/>

## Purpose and limitations

### What the AERO generator does

This software takes a tab-delimited text file generated by your spreadsheet programme of choice (e.g. Excel or OpenOffice) and parses it, producing one node of an AERO diagram per row, and allowing you to save the output as a standard LaTeX file (requiring the tikz package) or, if your server supports it, saving the output as a PDF directly.

### What the AERO generator doesn't do

* Magic
* Does not do your meta-analysis for you
* Does not check your data points
* Does not warn you before an error

## Installation requirements

You may be able to install the AERO generator on setups different from what is described below, but the following is what it was designed for.

* Apache 2.2.22-14
* PHP 5.3.27
* MySQL 5

Copy the entire file to your web server, and navigate to the AERO generator directory with your browser. You will need to know your MySQL server, username and password to complete the installation.

## Contact info

I cannot guarantee that I will be able to help you with your problems. Depending on the nature and scope of your problems, you may be better off calling 911 or admitting yourself to the nearest hospital. That said, if you have found bugs, or if you have ideas for future directions for the software, here are some reasonably reliable ways to contact me.

* Email: <benjamin.carlisle@mcgill.ca>
* Twitter: @stream_research
* Post: Room 304, 3647 rue Peel, Montréal QC H1M 2N9

Best,

Benjamin Carlisle  
Murph E.