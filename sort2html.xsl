<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html"/>
<xsl:strip-space elements="*"/>
<xsl:template match="/">
<html>
<head>
<h1>List of Prominent Persons</h1>
</head>
<body>
<ol>
<xsl:apply-templates/>
</ol>
</body>
</html>
</xsl:template>
<xsl:template match="/list">
<xsl:apply-templates>
<xsl:sort select="family_name"/>
</xsl:apply-templates>
</xsl:template>
<xsl:template match="person">
<li>
<xsl:value-of select="personal_name"/>
<xsl:text>&#x9;</xsl:text>
<xsl:value-of select="family_name"/>
</li>
</xsl:template>
</xsl:stylesheet>