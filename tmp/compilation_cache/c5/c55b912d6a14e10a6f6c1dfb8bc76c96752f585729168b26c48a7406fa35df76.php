<?php

/* index.html */
class __TwigTemplate_5d49b4249bb71a92f893b575e8263deda1ebd3763c74afd4f0b57c35ae286c57 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <title>My Webpage</title>
    </head>
    <body>
      ss
      <ul id=\"navigation\">
        ";
        // line 9
        echo twig_escape_filter($this->env, ($context["stajgunleri"] ?? null), "html", null, true);
        echo "
        ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["stajgunleri"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 11
            echo "        sss
          ";
            // line 12
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["item"]);
            foreach ($context['_seq'] as $context["_key"] => $context["it"]) {
                // line 13
                echo "          <li><a href=\"\">2";
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $context["it"], "m/d/Y"), "html", null, true);
                echo "</a></li>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['it'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 15
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "        </ul>
    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 16,  57 => 15,  48 => 13,  44 => 12,  41 => 11,  37 => 10,  33 => 9,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.html", "/var/www/localhost/htdocs/staj_tarih_hesaplama/templates/index.html");
    }
}
