<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="text" omit-xml-declaration="yes" indent="no"/>
<xsl:strip-space elements="*"/>
<xsl:template match="/list" indent="yes">
<xsl:apply-templates>
<xsl:sort select="family_name"/>
</xsl:apply-templates>
</xsl:template>
<xsl:template match="person">
<xsl:value-of select="personal_name"/>
<xsl:text>&#x9;</xsl:text>
<xsl:value-of select="family_name"/>	
<xsl:text>&#x9;</xsl:text>
<xsl:text>&#x0d;&#x0a;</xsl:text>
</xsl:template>
</xsl:stylesheet>