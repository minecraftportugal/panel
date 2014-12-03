<!DOCTYPE html>
<html>

    <head>
      <link rel="stylesheet" href="/styles/reset.css" media="screen" type="text/css">
    </head>

    <body>
        <div id="div">
            <applet code="net.minecraft.Launcher" archive="https://s3.amazonaws.com/Minecraft.Download/launcher/Minecraft.jar" codebase="/game/" width="854" height="480">
                <param name="separate_jvm" value="true">
                <param name="java_arguments" value="-Xmx1024M -Xms1024M -Dsun.java2d.noddraw=true -Dsun.awt.noerasebackground=true -Dsun.java2d.d3d=false -Dsun.java2d.opengl=false -Dsun.java2d.pmoffscreen=false">
                <param name="userName" value="Player">
                <param name="latestVersion" value="1326382442000">
                <param name="downloadTicket" value="0">
                <param name="sessionId" value="0">
                <param name="sessionId" value="<?= $user['playername'] ?>">
            </applet>
        </div>
    </body>

</html>
