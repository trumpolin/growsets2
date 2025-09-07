import FacetPanel, { FacetPanelGroup } from "@/components/FacetPanel";

export default function Home() {
  return (
    <>
      <section className="bg-primary text-white py-18">
        <div className="container mx-auto px-4 text-center">
          <h1 className="mb-4 text-4xl font-display">Growsets</h1>
          <p className="mx-auto mb-8 max-w-2xl text-lg">
            Growsets ist ein Projekt, das dir hilft, die passende Kombination
            aus Growbox, Beleuchtung und Belüftung zu finden.
          </p>
          <a
            href="configurator"
            className="inline-block rounded bg-secondary px-6 py-3 font-semibold text-white hover:bg-accent"
          >
            Zum Konfigurator
          </a>
        </div>
      </section>

      <section className="container mx-auto my-18 px-4">
        <h2 className="mb-4 text-2xl font-semibold text-primary">
          Beispiel‑Panels
        </h2>

        <FacetPanelGroup>
          <FacetPanel id="demo1" title="Neue Produkte">
            <ul className="divide-y">
              <li className="flex items-center gap-4 py-2">
                <img
                  src="/sample1.jpg"
                  alt="Produkt 1"
                  className="h-20 w-20 rounded object-cover"
                />
                <div>
                  <h3 className="font-medium">Produktname 1</h3>
                  <p className="text-sm text-gray-600">
                    Kurzbeschreibung des Produkts.
                  </p>
                  <span className="font-bold">€ 0,00</span>
                </div>
              </li>

              <li className="flex items-center gap-4 py-2">
                <img
                  src="/sample2.jpg"
                  alt="Produkt 2"
                  className="h-20 w-20 rounded object-cover"
                />
                <div>
                  <h3 className="font-medium">Produktname 2</h3>
                  <p className="text-sm text-gray-600">
                    Kurzbeschreibung des Produkts.
                  </p>
                  <span className="font-bold">€ 0,00</span>
                </div>
              </li>
            </ul>
          </FacetPanel>

          <FacetPanel
            id="demo2"
            title="Beliebt"
            selectedItems={["Alpha", "Beta"]}
          >
            <p className="text-sm">
              Weitere Inhalte oder Filteroptionen können hier eingeblendet
              werden.
            </p>
          </FacetPanel>
        </FacetPanelGroup>
      </section>
    </>
  );
}
