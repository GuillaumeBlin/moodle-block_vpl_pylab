Moodle 2.0+ block allowing mpld3 support for vpl
================

Synthesis
------------

This project allows to add a block to any wanted vpl activity in order to provide a support to mpld3.
  
Installation
------------

To install the plugin using git, execute the following commands in the root of your Moodle install:

    git clone https://github.com/GuillaumeBlin/moodle-block_vpl_pylab.git your_moodle_root/blocks/vpl_pylab
    
Or, extract the following zip in `your_moodle_root/blocks/` as follows:

    cd your_moodle_root/blocks/
    wget https://github.com/GuillaumeBlin/moodle-block_vpl_pylab/archive/master.zip
    unzip -j master.zip -d vpl_pylab

Use
------------

For each vpl activity you want to allow mpld3 support, add the "VPL Pylab block" using "Add a block" in the edit mode.
In the configuration of the "VPL Pylab block", the option "Display on page types" should be set to "mod-vpl-*".

Authors and Contributors
------------

In 2017, Guillaume Blin (@GuillaumeBlin).
