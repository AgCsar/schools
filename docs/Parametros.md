# Parametros de filtros, ordenação e pesquisa

Cada parâmetro de consulta, exceto as funções pré-definidas _with, _sort e _q, é interpretado como um filtro.

Exemplo: Listar todas as escola que começam com nome: Vieira.

<pre><code>/api/schools?name-lk=Vieira*</code></pre>

No exemplo acima o parametro name recebe o nome vieira que e o nome da escola, é com prefixo -lk sendo este igual a like do sql.

Todos os filtros podem ser combinados com um operador AND.

<pre><code>/api/schools?name-lk=Vieira*&created_at-min=2016-12-01 12:55:02</code></pre>

O exemplo acima resultaria na seguinte SQL:

<pre><code>Where `schools` LIKE "Vieira%" AND `created_at` >= "2016-12-01 12:55:02"</code></pre>

É também possível usar vários valores para um filtro.
Vários valores estão separados por um tubo |.
Vários valores são combinados com OR a não ser quando há um -not como sufixo, então eles são combinados com AND.
Por exemplo, todos os livros com o ID de 5 ou 6:

<pre><code>/api/schools?id=5|6</code></pre>

Ou todos os livros, exceto aqueles com ID 5 ou 6:

<pre><code>/api/schools?id-not=5|6</code></pre>

O mesmo pode ser conseguido usando o -in como sufixo:

<pre><code>/api/schools?id-in=5,6</code></pre>

Respectivamente, o not-insufixo:

<pre><code>/api/schools?id-not-in=5,6</code></pre>

| Suffix        | Operator  | Meaning                               |
|:--------------|-----------|---------------------------------------|
| `-lk`         | LIKE      | O mesmo que o operador LIKE do SQL    |
| `-not-lk`     | NOT LIKE  | O mesmo que o operador NOT LIKE do SQL|
| `-in`         | IN        | O mesmo que o operador IN do SQL      |
| `-not-in`     | NOT IN    | O mesmo que o operador NOT IN do SQL  |
| `-min`        | >=        | Maior ou igual a                      |
| `-max`        | <=        | Menor ou igual a                      |
| `-st`         | <         | Menor que                             |
| `-gt`         | >         | Maior que                             |
| `-not`        | !=        | Diferente                             |


