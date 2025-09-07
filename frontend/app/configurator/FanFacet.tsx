"use client";
import ArticleFacet from "./ArticleFacet";

export default function FanFacet() {
  return (
    <ArticleFacet
      category="fan"
      selectionKey="fan"
      title="Lüfter"
      queryKey={["fanArticles"]}
    />
  );
}
