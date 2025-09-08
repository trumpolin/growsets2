import type { Metadata } from "next";
import "./globals.css";
import { SelectionProvider } from "@/components/SelectionProvider";
import QueryProvider from "@/components/QueryProvider";

export const metadata: Metadata = {
  title: "Growsets",
  description: "Komplett Konfigurator",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body className="antialiased">
        <QueryProvider>
          <SelectionProvider>
            <div className="flex min-h-screen flex-col">
              <header className="bg-primary text-white">
                <div className="container mx-auto p-4">
                  <div className="text-xl font-bold">Komplett Konfigurator</div>
                </div>
              </header>
              <main className="container mx-auto flex-grow p-4">
                {children}
              </main>
              <footer className="bg-primary p-4 text-center text-white">
                &copy; {new Date().getFullYear()} Growsets
              </footer>
            </div>
          </SelectionProvider>
        </QueryProvider>
      </body>
    </html>
  );
}
